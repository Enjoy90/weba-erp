<?php

use Carbon\Carbon;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use Weba\ProductionPriority\Database\Seeders\CriterionSeeder;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\OrderMonitoringResource;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\OrderMonitoringResource\Pages\ListOrderMonitoring;
use Weba\ProductionPriority\Filament\Pages\WorkPanel;
use Weba\ProductionPriority\Models\Evaluation;
use Weba\ProductionPriority\Models\EvaluationItem;
use Weba\ProductionPriority\Services\EvaluationService;
use Webkul\Manufacturing\Enums\WorkOrderState;
use Webkul\Manufacturing\Filament\Clusters\Operations\Resources\ManufacturingOrderResource;
use Webkul\Manufacturing\Models\Order;
use Webkul\PluginManager\Models\Plugin;
use Webkul\PluginManager\Package;
use Webkul\Security\PermissionRegistrar;

require_once __DIR__.'/../../../../webkul/support/tests/Helpers/TestBootstrapHelper.php';
require_once __DIR__.'/../../../../webkul/support/tests/Helpers/SecurityHelper.php';
require_once __DIR__.'/../../../../webkul/inventories/tests/Helpers/InventoryHelper.php';
require_once __DIR__.'/../../../../webkul/manufacturing/tests/Helpers/ManufacturingHelper.php';

beforeEach(function () {
    TestBootstrapHelper::ensurePluginInstalled('inventories');
    TestBootstrapHelper::ensurePluginInstalled('manufacturing');
    TestBootstrapHelper::ensurePluginInstalled('production-priority');

    (new CriterionSeeder)->run();

    foreach (['inventories', 'manufacturing', 'production-priority'] as $plugin) {
        DB::table('plugins')->updateOrInsert(
            ['name' => $plugin],
            ['is_installed' => true, 'is_active' => true, 'updated_at' => now()],
        );
    }

    Package::$plugins = Plugin::all()->keyBy('name');

    URL::resolveMissingNamedRoutesUsing(fn () => '#');

    Filament::setCurrentPanel(Filament::getPanel('admin'));

    App::setLocale('en');

    $this->admin = ManufacturingHelper::actingAsAdmin();

    $this->warehouse = InventoryHelper::warehouse();
    $this->finished = ManufacturingHelper::product();
    $this->component = ManufacturingHelper::product();
    $this->workCenter = ManufacturingHelper::workCenter();
});

afterEach(function () {
    Carbon::setTestNow();
});

function wpOrder(object $test, ?int $deadlineInDays = 5, string $state = 'confirmed', float $reserved = 0): Order
{
    $bom = ManufacturingHelper::bom($test->finished, [[$test->component, 2]]);
    $order = ManufacturingHelper::confirm(ManufacturingHelper::order($test->warehouse, $test->finished, $bom, 5));

    DB::table('manufacturing_orders')->where('id', $order->id)->update([
        'deadline_at' => $deadlineInDays === null ? null : now()->addDays($deadlineInDays),
        'state'       => $state,
    ]);

    DB::table('inventories_moves')->where('raw_material_order_id', $order->id)->update(['quantity' => $reserved]);

    return $order->refresh();
}

/**
 * The application keeps its own permission registrar, which SecurityHelper does
 * not flush, so the permissions it just handed out would not be seen.
 *
 * @param  list<string>  $permissions
 */
function wpLimitedUser(array $permissions): void
{
    $user = SecurityHelper::authenticateWithPermissions($permissions);
    $user->forceFill(['is_active' => true])->saveQuietly();

    app(PermissionRegistrar::class)->forgetCachedPermissions();
}

/**
 * Counts the queries of one fresh page load. The application of a test lives
 * longer than a request, so two things from earlier are dropped first: the
 * scoped services (the overview would still hold the old data) and the chatter
 * notifications that creating orders registered, which the application runs
 * again each time a request ends and which would make the count grow with the
 * number of records the test created instead of with what the page does.
 */
function wpCountRenderQueries(): int
{
    app()->forgetScopedInstances();

    $callbacks = new ReflectionProperty(app(), 'terminatingCallbacks');
    $callbacks->setValue(app(), []);

    DB::flushQueryLog();
    DB::enableQueryLog();
    Livewire::test(WorkPanel::class);
    $count = count(DB::getQueryLog());
    DB::disableQueryLog();

    return $count;
}

function wpEvaluate(): Evaluation
{
    return app(EvaluationService::class)->run();
}

describe('header', function () {
    it('greets the user by name according to the time of day', function () {
        $name = $this->admin->name;

        foreach ([
            '2026-10-09 09:00:00' => 'Good morning, ',
            '2026-10-09 12:30:00' => 'Good afternoon, ',
            '2026-10-09 16:00:00' => 'Good evening, ',
            '2026-10-09 23:30:00' => 'Good evening, ',
        ] as $moment => $greeting) {
            Carbon::setTestNow(Carbon::parse($moment));

            expect((new WorkPanel)->getHeading())->toBe($greeting.$name);
        }

        App::setLocale('id');
        Carbon::setTestNow(Carbon::parse('2026-10-09 09:00:00'));

        expect((new WorkPanel)->getHeading())->toBe('Selamat pagi, '.$name);
    });

    it('sums up the date, the late orders and the orders due soon', function () {
        Carbon::setTestNow(Carbon::parse('2026-10-09 09:00:00'));

        wpOrder($this, -2);
        wpOrder($this, -1);
        wpOrder($this, 1);
        wpOrder($this, 20);

        expect((new WorkPanel)->getSubheading())
            ->toBe('Friday, 9 October 2026. Late orders: 2. Due within 3 days: 1.');
    });

    it('runs SAW from the header and stays on the page', function () {
        wpOrder($this);

        Livewire::test(WorkPanel::class)
            ->callAction('runEvaluation', ['name' => 'Dari panel'])
            ->assertNoRedirect()
            ->assertNotified()
            ->assertSee('Dari panel');

        expect(Evaluation::withoutGlobalScopes()->where('name', 'Dari panel')->exists())->toBeTrue();
    });

    it('hides the run button from a user who may not create evaluations', function () {
        wpLimitedUser(['page_production_priority_work_panel', 'view_any_manufacturing_manufacturing::order']);

        Livewire::test(WorkPanel::class)
            ->assertSuccessful()
            ->assertActionHidden('runEvaluation');
    });
});

describe('late orders card', function () {
    it('names the late orders, links the first four and says how many are left', function () {
        $orders = collect(range(1, 6))->map(fn (int $days) => wpOrder($this, -$days));

        $component = Livewire::test(WorkPanel::class);

        $component->assertSee('Deal with late orders')->assertSee('and 2 more');

        foreach ($orders->take(4) as $order) {
            $component->assertSeeHtml('href="'.ManufacturingOrderResource::getUrl('view', ['record' => $order]).'"');
        }

        $component->assertSeeHtml(e(OrderMonitoringResource::getUrl('index', ['filters' => ['late' => ['isActive' => true]]])));
    });

    it('links to a monitoring list that really shows only the late orders', function () {
        $late = wpOrder($this, -3);
        $onTime = wpOrder($this, 6);

        $url = OrderMonitoringResource::getUrl('index', ['filters' => ['late' => ['isActive' => true]]]);
        parse_str((string) parse_url($url, PHP_URL_QUERY), $query);

        Livewire::withQueryParams($query)
            ->test(ListOrderMonitoring::class)
            ->assertCanSeeTableRecords([$late])
            ->assertCanNotSeeTableRecords([$onTime]);
    });

    it('says so when nothing is late and offers no button', function () {
        wpOrder($this, 5);

        Livewire::test(WorkPanel::class)
            ->assertSee('No late orders.')
            ->assertDontSee('View late orders');
    });
});

describe('priority card', function () {
    it('offers to run SAW while there is no evaluation', function () {
        wpOrder($this);

        Livewire::test(WorkPanel::class)
            ->assertSee('There is no SAW result yet')
            ->assertSee('Run SAW')
            ->assertActionHidden('applyPriority');
    });

    it('goes from ready to applied and back when the user applies and reverts', function () {
        collect(range(1, 3))->each(fn (int $days) => wpOrder($this, $days));
        $evaluation = wpEvaluate();

        $component = Livewire::test(WorkPanel::class)
            ->assertSee('is ready. Make the top 3 orders Urgent.')
            ->assertActionVisible('applyPriority')
            ->assertActionHidden('revertPriority');

        $component
            ->callAction('applyPriority', ['top_n' => 2, 'reason' => 'Pelanggan penting'])
            ->assertNoRedirect()
            ->assertSee('Applied by '.$this->admin->name)
            ->assertSee('for the top 2 orders')
            ->assertActionHidden('applyPriority')
            ->assertActionVisible('revertPriority');

        expect($evaluation->fresh()->isApplied())->toBeTrue();

        $component
            ->callAction('revertPriority')
            ->assertSee('is ready. Make the top 3 orders Urgent.')
            ->assertActionVisible('applyPriority');

        expect($evaluation->fresh()->isApplied())->toBeFalse();
    });

    it('proposes at most five orders and no more than the evaluation holds', function () {
        collect(range(1, 7))->each(fn (int $days) => wpOrder($this, $days));
        wpEvaluate();

        Livewire::test(WorkPanel::class)
            ->assertSee('Make the top 5 orders Urgent.')
            ->mountAction('applyPriority')
            ->assertActionDataSet(['top_n' => 5]);
    });

    it('keeps the apply and revert buttons from a user without the apply ability, even one who may update evaluations', function () {
        wpOrder($this);
        wpEvaluate();

        wpLimitedUser([
            'page_production_priority_work_panel', 'view_any_manufacturing_manufacturing::order',
            'view_any_production_priority_evaluation', 'update_production_priority_evaluation',
        ]);

        Livewire::test(WorkPanel::class)
            ->assertSuccessful()
            ->assertSee('is ready.')
            ->assertActionHidden('applyPriority');
    });
});

describe('material card', function () {
    it('counts the orders short of material and names the largest shortage', function () {
        wpOrder($this, 5, reserved: 0);
        wpOrder($this, 5, reserved: 10);

        Livewire::test(WorkPanel::class)
            ->assertSee('Complete the raw materials')
            ->assertSee('Largest shortage: '.$this->component->name);
    });

    it('says so when all material is there', function () {
        wpOrder($this, 5, reserved: 10);

        Livewire::test(WorkPanel::class)->assertSee('All raw materials of the active orders are available.');
    });

    it('offers no purchase button when the purchase module is not installed', function () {
        wpOrder($this, 5, reserved: 0);

        Livewire::test(WorkPanel::class)->assertDontSee('Create a purchase request');
    });
});

describe('figures', function () {
    it('shows the four figures of the summary with an explanation each', function () {
        Carbon::setTestNow(Carbon::parse('2026-10-09 09:00:00'));

        wpOrder($this, 1);
        wpOrder($this, 20);

        Livewire::test(WorkPanel::class)
            ->assertSee('Active orders')
            ->assertSee('Due in 3 days')
            ->assertSee('Average progress')
            ->assertSee('Remaining workload')
            ->assertSee('Orders that are confirmed, in progress, or ready to close.')
            ->assertSeeHtml('aria-label="Explain Active orders"');
    });
});

/**
 * The value shown in the figure tile with the given label.
 */
function wpFigure(string $html, string $label): ?string
{
    return preg_match('/'.preg_quote($label, '/').'.*?wp-stat-value">\s*([^<\s]+)/s', $html, $match) === 1 ? $match[1] : null;
}

/**
 * The numbers on the task cards, in the order of the cards.
 *
 * @return list<string>
 */
function wpCardNumbers(string $html): array
{
    preg_match_all('/<span class="wp-task-count">(\d+)<\/span>/', $html, $matches);

    return $matches[1];
}

describe('numbers', function () {
    it('shows the right value in each of the four figures', function () {
        Carbon::setTestNow(Carbon::parse('2026-10-09 09:00:00'));

        $withWork = wpOrder($this, -2);
        wpOrder($this, 1);
        wpOrder($this, 20);

        ManufacturingHelper::workOrder($withWork, $this->workCenter, null, ['state' => WorkOrderState::DONE, 'expected_duration' => 60]);
        ManufacturingHelper::workOrder($withWork, $this->workCenter, null, ['state' => WorkOrderState::PENDING, 'expected_duration' => 60]);

        $html = Livewire::test(WorkPanel::class)->html();

        expect(wpFigure($html, 'Active orders'))->toBe('3')
            ->and(wpFigure($html, 'Due in 3 days'))->toBe('1')
            ->and(wpFigure($html, 'Average progress'))->toBe('17%')
            ->and(wpFigure($html, 'Remaining workload'))->toBe('1');
    });

    it('shows the right number on each task card', function () {
        collect([-4, -3, -2])->each(fn (int $days) => wpOrder($this, $days));
        wpOrder($this, 6, reserved: 10);
        wpEvaluate();

        $html = Livewire::test(WorkPanel::class)->html();

        expect(wpCardNumbers($html))->toBe(['3', '4', '3']);
    });

    it('counts at most five orders on the card that applies the priorities', function () {
        collect(range(1, 8))->each(fn (int $days) => wpOrder($this, $days, reserved: 10));
        wpEvaluate();

        expect(wpCardNumbers(Livewire::test(WorkPanel::class)->html())[1])->toBe('5');
    });

    it('opens without a single order and shows zeros and the empty messages', function () {
        $html = Livewire::test(WorkPanel::class)
            ->assertSuccessful()
            ->assertSee('No late orders.')
            ->assertSee('All raw materials of the active orders are available.')
            ->assertSee('There is no SAW result yet')
            ->html();

        expect(wpCardNumbers($html))->toBe(['0', '0'])
            ->and(wpFigure($html, 'Active orders'))->toBe('0')
            ->and(wpFigure($html, 'Due in 3 days'))->toBe('0')
            ->and(wpFigure($html, 'Average progress'))->toBe('0%')
            ->and(wpFigure($html, 'Remaining workload'))->toBe('0');
    });
});

describe('tabs', function () {
    it('starts on the priority ranking and shows the count of each tab', function () {
        wpOrder($this);
        wpOrder($this);
        wpEvaluate();

        Livewire::test(WorkPanel::class)
            ->assertSet('activeTab', WorkPanel::TAB_PRIORITY)
            ->assertSee('Priority ranking')
            ->assertSee('Work center load')
            ->assertSee('Order status');
    });

    it('switches tab and keeps it when the page refreshes by itself', function () {
        wpOrder($this);

        Livewire::test(WorkPanel::class)
            ->call('setActiveTab', WorkPanel::TAB_STATUS)
            ->assertSet('activeTab', WorkPanel::TAB_STATUS)
            ->call('$refresh')
            ->assertSet('activeTab', WorkPanel::TAB_STATUS)
            ->assertSee('Spread of 1 orders by stage');
    });

    it('opens the tab named in the address and ignores a tab that does not exist', function () {
        Livewire::withQueryParams(['tab' => WorkPanel::TAB_WORK_CENTERS])
            ->test(WorkPanel::class)
            ->assertSet('activeTab', WorkPanel::TAB_WORK_CENTERS);

        Livewire::test(WorkPanel::class)
            ->call('setActiveTab', 'nonsense')
            ->assertSet('activeTab', WorkPanel::TAB_PRIORITY);

        Livewire::withQueryParams(['tab' => 'nonsense'])
            ->test(WorkPanel::class)
            ->assertOk();
    });

    it('refreshes by itself every minute while the tab is visible', function () {
        Livewire::test(WorkPanel::class)->assertSeeHtml('wire:poll.60s.visible');
    });
});

describe('priority table', function () {
    it('lists the orders of the latest evaluation by rank with a link to each order', function () {
        $late = wpOrder($this, -2);
        wpOrder($this, 4);
        wpOrder($this, 12);
        $evaluation = wpEvaluate();

        $items = $evaluation->items()->get();

        Livewire::test(WorkPanel::class)
            ->assertCanSeeTableRecords($items, inOrder: true)
            ->assertTableActionHasUrl('open', ManufacturingOrderResource::getUrl('view', ['record' => $late]), $items->firstWhere('manufacturing_order_id', $late->id))
            ->assertSee($late->name)
            ->assertSee('Late');
    });

    it('filters on the orders that need attention and the orders in progress', function () {
        $late = wpOrder($this, -2);
        $soon = wpOrder($this, 1);
        $running = wpOrder($this, 15, state: 'progress');
        $quiet = wpOrder($this, 15);
        $evaluation = wpEvaluate();

        $itemOf = fn (Order $order): EvaluationItem => $evaluation->items()->where('manufacturing_order_id', $order->id)->firstOrFail();

        Livewire::test(WorkPanel::class)
            ->call('setRowFilter', WorkPanel::FILTER_ATTENTION)
            ->assertCanSeeTableRecords([$itemOf($late), $itemOf($soon)])
            ->assertCanNotSeeTableRecords([$itemOf($running), $itemOf($quiet)])
            ->call('setRowFilter', WorkPanel::FILTER_PROGRESS)
            ->assertCanSeeTableRecords([$itemOf($running)])
            ->assertCanNotSeeTableRecords([$itemOf($late), $itemOf($soon), $itemOf($quiet)])
            ->call('setRowFilter', WorkPanel::FILTER_ALL)
            ->assertCanSeeTableRecords($evaluation->items()->get())
            ->call('setRowFilter', 'nonsense')
            ->assertSet('rowFilter', WorkPanel::FILTER_ALL);
    });

    it('keeps the filter when the page refreshes by itself', function () {
        wpOrder($this, -1);
        wpEvaluate();

        Livewire::test(WorkPanel::class)
            ->call('setRowFilter', WorkPanel::FILTER_ATTENTION)
            ->call('$refresh')
            ->assertSet('rowFilter', WorkPanel::FILTER_ATTENTION);
    });

    it('invites the user to run SAW when there is no evaluation', function () {
        Livewire::test(WorkPanel::class)->assertSee('No SAW result yet');
    });

    it('explains the empty result of a filter', function () {
        wpOrder($this, 15);
        wpEvaluate();

        Livewire::test(WorkPanel::class)
            ->call('setRowFilter', WorkPanel::FILTER_ATTENTION)
            ->assertSee('No order matches this filter.');
    });

    it('runs the same number of queries for one order and for many', function () {
        wpOrder($this);
        wpEvaluate();

        wpCountRenderQueries();
        $single = wpCountRenderQueries();

        collect(range(1, 5))->each(fn (int $days) => wpOrder($this, $days));
        wpEvaluate();

        $many = wpCountRenderQueries();

        expect($many)->toBe($single);
    });
});

describe('work center tab', function () {
    it('draws a bar per work center and lists the waiting and running orders', function () {
        $order = wpOrder($this);

        ManufacturingHelper::workOrder($order, $this->workCenter, null, ['state' => WorkOrderState::PROGRESS, 'expected_duration' => 120]);
        ManufacturingHelper::workOrder($order, ManufacturingHelper::workCenter(), null, ['state' => WorkOrderState::PENDING, 'expected_duration' => 60]);

        Livewire::test(WorkPanel::class)
            ->call('setActiveTab', WorkPanel::TAB_WORK_CENTERS)
            ->assertSee($this->workCenter->name)
            ->assertSee('2 hours')
            ->assertSee('1 hours')
            ->assertSeeHtml('width: 100%')
            ->assertSeeHtml('width: 50%');
    });

    it('says so when there is no work left', function () {
        Livewire::test(WorkPanel::class)
            ->call('setActiveTab', WorkPanel::TAB_WORK_CENTERS)
            ->assertSee('No work is left at any work center.');
    });
});

describe('status tab', function () {
    it('shows a legend with a count and a share for every state', function () {
        wpOrder($this);
        wpOrder($this);
        wpOrder($this, 5, state: 'progress');
        wpOrder($this, 5, state: 'to_close');

        Livewire::test(WorkPanel::class)
            ->call('setActiveTab', WorkPanel::TAB_STATUS)
            ->assertSee('Spread of 4 orders by stage')
            ->assertSeeHtml('var(--wp-state-confirmed)')
            ->assertSeeHtml('var(--wp-state-to-close)')
            ->assertSee('50%')
            ->assertSee('25%');
    });

    it('says so when there are no orders', function () {
        Livewire::test(WorkPanel::class)
            ->call('setActiveTab', WorkPanel::TAB_STATUS)
            ->assertSee('There are no orders yet.');
    });
});

describe('footer', function () {
    it('names the latest evaluation and links to it', function () {
        wpOrder($this);
        $evaluation = wpEvaluate();

        Livewire::test(WorkPanel::class)
            ->assertSee('Latest evaluation: '.$evaluation->name)
            ->assertSee('Open the full priority page');
    });

    it('says so when there is no evaluation yet', function () {
        Livewire::test(WorkPanel::class)->assertSee('There is no SAW evaluation yet.');
    });
});

describe('accessibility', function () {
    it('marks the tabs as a tab list, with only the open tab in the tab order', function () {
        wpOrder($this);

        Livewire::test(WorkPanel::class)
            ->assertSeeHtml('role="tablist"')
            ->assertSeeHtml('id="wp-tab-priority"')
            ->assertSeeHtml('aria-selected="true"')
            ->assertSeeHtml('aria-selected="false"')
            ->assertSeeHtml('tabindex="-1"')
            ->assertSeeHtml('role="tabpanel"')
            ->assertSeeHtml('aria-labelledby="wp-tab-priority"');
    });

    it('points the tab panel at the tab that is open', function () {
        wpOrder($this);

        $component = Livewire::test(WorkPanel::class)->call('setActiveTab', WorkPanel::TAB_STATUS);

        $component->assertSeeHtml('aria-labelledby="wp-tab-status"')
            ->assertDontSeeHtml('aria-labelledby="wp-tab-priority"');

        expect(substr_count($component->html(), 'aria-selected="true"'))->toBe(1);
    });

    it('gives every progress bar a name that tells which order it belongs to', function () {
        $order = wpOrder($this);
        wpEvaluate();

        Livewire::test(WorkPanel::class)
            ->assertSeeHtml('role="progressbar"')
            ->assertSeeHtml('aria-label="Progress of order '.$order->name.'"');
    });

    it('names the progress bars in both languages', function () {
        $order = wpOrder($this);
        wpEvaluate();

        App::setLocale('id');

        Livewire::test(WorkPanel::class)->assertSeeHtml('aria-label="Progres order '.$order->name.'"');
    });

    it('keeps the status readable without color, as text next to the dot or icon', function () {
        wpOrder($this, -2);
        wpEvaluate();

        Livewire::test(WorkPanel::class)
            ->assertSeeHtml('wp-state-dot')
            ->assertSee('Confirmed')
            ->assertSee('days late');
    });
});

describe('responsive rules', function () {
    it('makes the cards one column and the figures two columns below 1180 px', function () {
        $css = file_get_contents(__DIR__.'/../../resources/dist/work-panel.css');

        expect($css)->toMatch('/@media \(max-width: 1180px\)\s*\{\s*\.wp-tasks\s*\{\s*grid-template-columns: minmax\(0, 1fr\);\s*\}\s*\.wp-stats\s*\{\s*grid-template-columns: repeat\(2, minmax\(0, 1fr\)\);/');
    });

    it('lets wide tables and the tab list scroll sideways instead of widening the page', function () {
        $css = file_get_contents(__DIR__.'/../../resources/dist/work-panel.css');

        expect($css)->toContain('.wp-split')
            ->and($css)->toMatch('/\.wp-table \.fi-ta-ctn/');
    });

    it('keeps small controls at least 24 px to touch', function () {
        $css = file_get_contents(__DIR__.'/../../resources/dist/work-panel.css');

        expect($css)->toMatch('/\.wp-chip\s*\{[^}]*min-height:\s*1\.5rem;/s')
            ->and($css)->toMatch('/\.wp-info::after\s*\{[^}]*inset:\s*-0\.25rem;/s');
    });
});
