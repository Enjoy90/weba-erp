<?php

namespace Weba\ProductionPriority;

use Closure;
use Filament\Forms\Components\DateTimePicker;
use Filament\Navigation\NavigationManager;
use Filament\Panel;
use Filament\Schemas\Schema;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Filament\Tables\Table;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Weba\ProductionPriority\Console\RunEvaluationCommand;
use Weba\ProductionPriority\Models\OrderAttribute;
use Weba\ProductionPriority\Navigation\WorkNavigationManager;
use Weba\ProductionPriority\Services\ProductionOverview;
use Weba\ProductionPriority\Support\LegacyMariaDbDialect;
use Weba\ProductionPriority\Support\ReversalTaxes;
use Webkul\Manufacturing\Models\Order;
use Webkul\PluginManager\Console\Commands\InstallCommand;
use Webkul\PluginManager\Console\Commands\UninstallCommand;
use Webkul\PluginManager\Package;
use Webkul\PluginManager\PackageServiceProvider;
use Webkul\Security\Models\User;
use Webkul\Support\Database\Dialects\DatabaseDialect;
use Webkul\Support\Database\Dialects\MySqlDialect;

class ProductionPriorityServiceProvider extends PackageServiceProvider
{
    public static string $name = 'production-priority';

    public static string $viewNamespace = 'production-priority';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews()
            ->hasTranslations()
            ->hasMigrations([
                '2026_10_08_000001_create_production_priority_criteria_table',
                '2026_10_08_000002_create_production_priority_order_attributes_table',
                '2026_10_08_000003_create_production_priority_evaluations_table',
                '2026_10_08_000004_create_production_priority_evaluation_items_table',
                '2026_10_09_000001_grant_work_panel_permission',
                '2026_10_11_000001_add_sale_order_to_production_priority_order_attributes_table',
                '2026_10_11_000002_grant_daily_report_permission',
                '2026_10_12_000001_create_production_roles',
                '2026_10_12_000002_add_indonesian_vat',
            ])
            ->runsMigrations()
            ->hasDependencies([
                'manufacturing',
            ])
            ->hasCommand(RunEvaluationCommand::class)
            ->hasSeeder('Weba\\ProductionPriority\\Database\\Seeders\\DatabaseSeeder')
            ->hasInstallCommand(function (InstallCommand $command): void {
                $command
                    ->installDependencies()
                    ->runsMigrations()
                    ->runsSeeders();
            })
            ->hasUninstallCommand(function (UninstallCommand $command): void {})
            ->icon('manufacturing');
    }

    public function packageBooted(): void
    {
        $this->contributeOrderRelations();

        $this->scheduleDailyEvaluation();

        $this->registerWorkPanelCss();

        $this->arrangeSidebar();

        $this->useIndonesianDateFormats();

        ReversalTaxes::listen();

        $this->giveSignedInUsersAContact();
    }

    /**
     * A user gets its contact (partner) when it is saved with model events; one
     * created without them has none, and the profile page then fails on it.
     * Saving the user again on sign-in creates the missing contact.
     */
    protected function giveSignedInUsersAContact(): void
    {
        Event::listen(Authenticated::class, function (Authenticated $event): void {
            if ($event->user instanceof User && ! $event->user->partner_id) {
                $event->user->save();
                $event->user->unsetRelation('partner');
            }
        });
    }

    /**
     * Filament writes dates as "Oct 11, 2026". In Indonesian the day comes first
     * ("11 Okt 2026"). The format is chosen when it is used, after the locale of
     * the request is known, so English keeps its own format.
     */
    protected function useIndonesianDateFormats(): void
    {
        $format = fn (string $indonesian, string $default): Closure => fn (): string => app()->getLocale() === 'id' ? $indonesian : $default;

        Table::configureUsing(fn (Table $table) => $table
            ->defaultDateDisplayFormat($format('j M Y', 'M j, Y'))
            ->defaultDateTimeDisplayFormat($format('j M Y H:i', 'M j, Y H:i:s')));

        Schema::configureUsing(fn (Schema $schema) => $schema
            ->defaultDateDisplayFormat($format('j M Y', 'M j, Y'))
            ->defaultDateTimeDisplayFormat($format('j M Y H:i', 'M j, Y H:i:s')));

        DateTimePicker::configureUsing(fn (DateTimePicker $picker) => $picker
            ->defaultDateDisplayFormat($format('j M Y', 'M j, Y'))
            ->defaultDateTimeDisplayFormat($format('j M Y H:i', 'M j, Y H:i'))
            ->defaultDateTimeWithSecondsDisplayFormat($format('j M Y H:i:s', 'M j, Y H:i:s')));
    }

    /**
     * Swaps the menu builder of Filament for one that only rearranges its
     * result. Booting happens after every provider registered, so this
     * binding is the one that stays.
     */
    protected function arrangeSidebar(): void
    {
        if (! Package::isPluginInstalled(static::$name)) {
            return;
        }

        $this->app->scoped(NavigationManager::class, fn (): NavigationManager => new WorkNavigationManager);
    }

    protected function registerWorkPanelCss(): void
    {
        FilamentAsset::register([
            Css::make('work-panel', __DIR__.'/../resources/dist/work-panel.css'),
            Css::make('sidebar', __DIR__.'/../resources/dist/sidebar.css'),
            Css::make('login', __DIR__.'/../resources/dist/login.css'),
        ], static::$name);
    }

    protected function scheduleDailyEvaluation(): void
    {
        if (! Package::isPluginInstalled(static::$name)) {
            return;
        }

        $this->callAfterResolving(Schedule::class, function (Schedule $schedule): void {
            $schedule->command('production-priority:run')
                ->dailyAt('06:00')
                ->withoutOverlapping();
        });
    }

    protected function contributeOrderRelations(): void
    {
        if (! Package::isPluginInstalled(static::$name)) {
            return;
        }

        Order::resolveRelationUsing('priorityAttribute', fn (Order $order) => $order->hasOne(
            OrderAttribute::class,
            'manufacturing_order_id',
        ));
    }

    public function packageRegistered(): void
    {
        $this->app->scoped(ProductionOverview::class);

        $this->app->extend(DatabaseDialect::class, fn (DatabaseDialect $dialect): DatabaseDialect => $dialect instanceof MySqlDialect && LegacyMariaDbDialect::isNeededFor(DB::connection())
            ? new LegacyMariaDbDialect
            : $dialect);

        Panel::configureUsing(function (Panel $panel): void {
            $panel->plugin(ProductionPriorityPlugin::make());
        });
    }
}
