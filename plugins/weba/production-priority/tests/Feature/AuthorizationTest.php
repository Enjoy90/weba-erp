<?php

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use Weba\ProductionPriority\Database\Seeders\CriterionSeeder;
use Weba\ProductionPriority\Database\Seeders\ProductionRoleSeeder;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\CriterionResource;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\CriterionResource\Pages\ListCriteria;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\EvaluationResource;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\EvaluationResource\Pages\ViewEvaluation;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\OrderMonitoringResource;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\OrderMonitoringResource\Pages\ListOrderMonitoring;
use Weba\ProductionPriority\Filament\Pages\DailyProductionReport;
use Weba\ProductionPriority\Filament\Pages\ProductionDashboard;
use Weba\ProductionPriority\Filament\Pages\WorkPanel;
use Weba\ProductionPriority\Filament\Widgets\LateOrdersWidget;
use Weba\ProductionPriority\Filament\Widgets\WorkCenterLoadWidget;
use Weba\ProductionPriority\Models\Criterion;
use Weba\ProductionPriority\Models\Evaluation;
use Weba\ProductionPriority\Models\OrderAttribute;
use Weba\ProductionPriority\Services\EvaluationService;
use Weba\ProductionPriority\Services\OrderValueResolver;
use Weba\ProductionPriority\Services\PriorityApplier;
use Weba\ProductionPriority\Services\ProductionOverview;
use Weba\ProductionPriority\Services\Reports\OrderMonitoringReportBuilder;
use Weba\ProductionPriority\Services\Reports\PriorityRankingReportBuilder;
use Weba\ProductionPriority\Support\Abilities;
use Weba\ProductionPriority\Support\ProductionRoles;
use Webkul\Manufacturing\Enums\ManufacturingOrderPriority;
use Webkul\Manufacturing\Enums\WorkOrderState;
use Webkul\Manufacturing\Models\Order;
use Webkul\PluginManager\Models\Plugin;
use Webkul\PluginManager\Package;
use Webkul\Sale\Enums\OrderState as SaleOrderState;
use Webkul\Security\Bouncer;
use Webkul\Security\Enums\PermissionType;
use Webkul\Security\Models\Permission;
use Webkul\Security\Models\Role;
use Webkul\Security\PermissionRegistrar;
use Webkul\Support\Models\Company;

require_once __DIR__.'/../../../../webkul/support/tests/Helpers/TestBootstrapHelper.php';
require_once __DIR__.'/../../../../webkul/support/tests/Helpers/SecurityHelper.php';
require_once __DIR__.'/../../../../webkul/inventories/tests/Helpers/InventoryHelper.php';
require_once __DIR__.'/../../../../webkul/manufacturing/tests/Helpers/ManufacturingHelper.php';
require_once __DIR__.'/../../../../webkul/sales/tests/Helpers/SaleHelper.php';

/*
 * Phase 9 (todo 9.1 to 9.3, PRD E2): what each role may do, and that nobody can
 * reach or change data they have no right to. Data is made as the administrator;
 * the checks then run as the user under test.
 */

beforeEach(function () {
    TestBootstrapHelper::ensurePluginInstalled('inventories');
    TestBootstrapHelper::ensurePluginInstalled('manufacturing');
    TestBootstrapHelper::ensurePluginInstalled('sales');
    TestBootstrapHelper::ensurePluginInstalled('production-priority');

    (new CriterionSeeder)->run();
    (new ProductionRoleSeeder)->run();

    foreach (['inventories', 'manufacturing', 'sales', 'production-priority'] as $plugin) {
        DB::table('plugins')->updateOrInsert(
            ['name' => $plugin],
            ['is_installed' => true, 'is_active' => true, 'updated_at' => now()],
        );
    }

    Package::$plugins = Plugin::all()->keyBy('name');

    URL::resolveMissingNamedRoutesUsing(fn () => '#');

    Filament::setCurrentPanel(Filament::getPanel('admin'));

    $this->admin = ManufacturingHelper::actingAsAdmin();

    $this->company = ManufacturingHelper::company();
    $this->warehouse = InventoryHelper::warehouse();
    $this->finished = ManufacturingHelper::product();
    $this->component = ManufacturingHelper::product();
    $this->workCenter = ManufacturingHelper::workCenter();
});

/**
 * Signs in a user that has the given role, or the given permissions, and the
 * given range of records (global, group or individual).
 *
 * @param  list<string>  $permissions
 */
function azSignIn(?string $role = null, array $permissions = [], PermissionType $scope = PermissionType::GLOBAL): object
{
    $user = SecurityHelper::authenticateWithPermissions($permissions);

    if ($role !== null) {
        $user->assignRole(azRoleForTestGuard($role));
    }

    $user->forceFill(['is_active' => true, 'resource_permission' => $scope])->saveQuietly();

    app(PermissionRegistrar::class)->forgetCachedPermissions();
    azForgetRange();
    azRunAsWeb($scope !== PermissionType::GLOBAL);

    return $user->refresh();
}

/**
 * The ownership scope does nothing in the console, which is where tests run, so
 * a test about hidden records has to say that it is a web request.
 */
function azRunAsWeb(bool $isWeb): void
{
    (new ReflectionProperty(app(), 'isRunningInConsole'))->setValue(app(), ! $isWeb);
}

/**
 * The test sign-in uses the sanctum guard while the roles belong to the web
 * guard, so the role is copied to the guard of the test user.
 */
function azRoleForTestGuard(string $name): Role
{
    $web = Role::query()->where('name', $name)->where('guard_name', 'web')->firstOrFail();

    $role = Role::query()->firstOrCreate(['name' => $name, 'guard_name' => 'sanctum']);

    $role->syncPermissions($web->permissions->map(
        fn (Permission $permission): Permission => Permission::query()->firstOrCreate(['name' => $permission->name, 'guard_name' => 'sanctum'])
    )->all());

    return $role;
}

/**
 * The range of records of a user is remembered for the rest of the process.
 */
function azForgetRange(): void
{
    (new ReflectionProperty(Bouncer::class, 'authorizedUserIdsCache'))->setValue(null, null);
}

function azOrder(object $test, int $deadlineInDays = 5): Order
{
    $bom = ManufacturingHelper::bom($test->finished, [[$test->component, 2]]);
    $order = ManufacturingHelper::confirm(ManufacturingHelper::order($test->warehouse, $test->finished, $bom, 5));

    DB::table('manufacturing_orders')->where('id', $order->id)->update(['deadline_at' => now()->addDays($deadlineInDays)]);

    return $order->refresh();
}

function azEvaluation(object $test): Evaluation
{
    return app(EvaluationService::class)->run($test->company->id);
}

function azPriority(Order $order): ManufacturingOrderPriority
{
    return Order::withoutGlobalScopes()->find($order->id)->priority;
}

afterEach(function () {
    azRunAsWeb(false);
});

describe('roles', function () {
    $matrix = [
        ProductionRoles::MANAGER => [
            'workPanel' => true, 'dashboard' => true, 'dailyReport' => true, 'monitoring' => true,
            'criteria'  => true, 'criteriaWrite' => true, 'evaluations' => true, 'run' => true,
            'apply'     => true, 'attributes' => true, 'export' => true,
        ],
        ProductionRoles::SUPERVISOR => [
            'workPanel' => true, 'dashboard' => false, 'dailyReport' => true, 'monitoring' => true,
            'criteria'  => false, 'criteriaWrite' => false, 'evaluations' => true, 'run' => false,
            'apply'     => false, 'attributes' => false, 'export' => true,
        ],
        ProductionRoles::WAREHOUSE => [
            'workPanel' => true, 'dashboard' => false, 'dailyReport' => false, 'monitoring' => true,
            'criteria'  => false, 'criteriaWrite' => false, 'evaluations' => false, 'run' => false,
            'apply'     => false, 'attributes' => false, 'export' => false,
        ],
        ProductionRoles::LEADER => [
            'workPanel' => true, 'dashboard' => true, 'dailyReport' => true, 'monitoring' => true,
            'criteria'  => true, 'criteriaWrite' => false, 'evaluations' => true, 'run' => false,
            'apply'     => false, 'attributes' => false, 'export' => true,
        ],
    ];

    foreach ($matrix as $role => $expected) {
        it("gives the role {$role} exactly its own features", function () use ($role, $expected) {
            azOrder($this);
            $evaluation = azEvaluation($this);

            azSignIn($role);

            expect([
                'workPanel'     => WorkPanel::canAccess(),
                'dashboard'     => ProductionDashboard::canAccess(),
                'dailyReport'   => DailyProductionReport::canAccess(),
                'monitoring'    => OrderMonitoringResource::canViewAny(),
                'criteria'      => CriterionResource::canViewAny(),
                'criteriaWrite' => CriterionResource::canCreate(),
                'evaluations'   => EvaluationResource::canViewAny(),
                'run'           => Gate::allows('create', Evaluation::class),
                'apply'         => Gate::allows('apply', $evaluation),
                'attributes'    => Abilities::allows(Abilities::SET_ORDER_ATTRIBUTES),
                'export'        => Abilities::allows(Abilities::EXPORT_REPORT),
            ])->toBe($expected);
        });
    }

    it('keeps the administrator able to do everything', function () {
        azOrder($this);
        $evaluation = azEvaluation($this);

        expect(WorkPanel::canAccess())->toBeTrue()
            ->and(DailyProductionReport::canAccess())->toBeTrue()
            ->and(Gate::allows('apply', $evaluation))->toBeTrue()
            ->and(Abilities::allows(Abilities::SET_ORDER_ATTRIBUTES))->toBeTrue()
            ->and(Abilities::allows(Abilities::EXPORT_REPORT))->toBeTrue();
    });

    it('does not overwrite a role that somebody edited', function () {
        $role = Role::query()->where('name', ProductionRoles::LEADER)->firstOrFail();
        $role->syncPermissions([]);

        (new ProductionRoleSeeder)->run();

        expect($role->refresh()->permissions)->toHaveCount(0);
    });

    it('creates every role of the PRD', function () {
        foreach (array_keys(ProductionRoles::definitions()) as $name) {
            expect(Role::query()->where('name', $name)->exists())->toBeTrue();
        }
    });
});

describe('pages and widgets', function () {
    it('need the permission to read orders, not only the page permission', function () {
        azSignIn(permissions: [
            'page_production_priority_work_panel',
            'page_production_priority_production_dashboard',
            'page_production_priority_daily_report',
            'widget_production_priority_late_orders_widget',
            'widget_production_priority_work_center_load_widget',
        ]);

        expect(WorkPanel::canAccess())->toBeFalse()
            ->and(ProductionDashboard::canAccess())->toBeFalse()
            ->and(DailyProductionReport::canAccess())->toBeFalse()
            ->and(LateOrdersWidget::canView())->toBeFalse()
            ->and(WorkCenterLoadWidget::canView())->toBeFalse();
    });

    it('need the permission on work orders for the daily report', function () {
        azSignIn(permissions: [
            'page_production_priority_daily_report',
            'view_any_manufacturing_manufacturing::order',
        ]);

        expect(DailyProductionReport::canAccess())->toBeFalse();
    });

    it('show no evaluation to a user who may not read evaluations', function () {
        azOrder($this);
        azEvaluation($this);

        azSignIn(permissions: ['page_production_priority_work_panel', 'view_any_manufacturing_manufacturing::order', 'view_manufacturing_manufacturing::order']);

        app()->forgetInstance(ProductionOverview::class);

        expect(app(ProductionOverview::class)->latestEvaluation())->toBeNull();
    });

    it('keep the work orders of a hidden order out of the daily report', function () {
        $mine = azOrder($this);
        $hidden = azOrder($this);
        $workOrderOfHidden = ManufacturingHelper::workOrder($hidden, $this->workCenter, null, ['state' => WorkOrderState::DONE]);
        DB::table('manufacturing_work_orders')->where('id', $workOrderOfHidden->id)->update(['finished_at' => now()]);
        $workOrderOfMine = ManufacturingHelper::workOrder($mine, $this->workCenter, null, ['state' => WorkOrderState::DONE]);
        DB::table('manufacturing_work_orders')->where('id', $workOrderOfMine->id)->update(['finished_at' => now()]);
        DB::table('manufacturing_orders')->where('id', $mine->id)->update(['assigned_user_id' => null]);

        $user = azSignIn(ProductionRoles::SUPERVISOR, scope: PermissionType::INDIVIDUAL);
        DB::table('manufacturing_orders')->where('id', $mine->id)->update(['assigned_user_id' => $user->id]);

        Livewire::test(DailyProductionReport::class)
            ->assertCanSeeTableRecords([$workOrderOfMine->refresh()])
            ->assertCanNotSeeTableRecords([$workOrderOfHidden->refresh()]);
    });
});

describe('applying a priority', function () {
    it('lets a manager apply and revert it', function () {
        $order = azOrder($this);
        $evaluation = azEvaluation($this);

        azSignIn(ProductionRoles::MANAGER);

        Livewire::test(ViewEvaluation::class, ['record' => $evaluation->getKey()])
            ->callAction('applyPriority', ['top_n' => 1])
            ->assertNotified();

        expect(azPriority($order))->toBe(ManufacturingOrderPriority::URGENT);

        Livewire::test(ViewEvaluation::class, ['record' => $evaluation->getKey()])
            ->callAction('revertPriority')
            ->assertNotified();

        expect(azPriority($order))->toBe(ManufacturingOrderPriority::NORMAL);
    });

    it('hides the action from a user who may edit evaluations but has no apply ability', function () {
        azOrder($this);
        $evaluation = azEvaluation($this);

        azSignIn(permissions: [
            'view_any_production_priority_evaluation', 'view_production_priority_evaluation',
            'update_production_priority_evaluation',
            'view_any_manufacturing_manufacturing::order', 'update_manufacturing_manufacturing::order',
        ]);

        Livewire::test(ViewEvaluation::class, ['record' => $evaluation->getKey()])
            ->assertActionHidden('applyPriority');
    });

    it('changes nothing when the user may not update manufacturing orders', function () {
        $order = azOrder($this);
        $evaluation = azEvaluation($this);

        azSignIn(permissions: [
            'view_any_production_priority_evaluation', 'view_production_priority_evaluation',
            Abilities::APPLY_EVALUATION,
            'view_any_manufacturing_manufacturing::order', 'view_manufacturing_manufacturing::order',
        ]);

        Livewire::test(ViewEvaluation::class, ['record' => $evaluation->getKey()])
            ->callAction('applyPriority', ['top_n' => 1]);

        expect(azPriority($order))->toBe(ManufacturingOrderPriority::NORMAL)
            ->and($evaluation->refresh()->isApplied())->toBeFalse();
    });

    it('changes nothing when one of the orders is hidden from the user', function () {
        $visible = azOrder($this, 2);
        $hidden = azOrder($this, 4);
        $evaluation = azEvaluation($this);

        $user = azSignIn(ProductionRoles::MANAGER, scope: PermissionType::INDIVIDUAL);
        DB::table('manufacturing_orders')->where('id', $visible->id)->update(['assigned_user_id' => $user->id]);
        azForgetRange();

        expect(fn () => app(PriorityApplier::class)->apply($evaluation, 2))->toThrow(LogicException::class, 'nothing was changed');

        expect(azPriority($visible))->toBe(ManufacturingOrderPriority::NORMAL)
            ->and(azPriority($hidden))->toBe(ManufacturingOrderPriority::NORMAL)
            ->and($evaluation->refresh()->isApplied())->toBeFalse();
    });

    it('refuses an evaluation that is not the newest', function () {
        azOrder($this);
        $old = azEvaluation($this);
        $new = azEvaluation($this);

        expect(fn () => app(PriorityApplier::class)->apply($old, 1))->toThrow(LogicException::class, 'newest');

        expect(app(PriorityApplier::class)->apply($new, 1))->toBe(1);
    });

    it('refuses to apply when no order needs a change', function () {
        $order = azOrder($this);
        $evaluation = azEvaluation($this);
        DB::table('manufacturing_orders')->where('id', $order->id)->update(['priority' => ManufacturingOrderPriority::URGENT->value]);

        expect(fn () => app(PriorityApplier::class)->apply($evaluation, 1))->toThrow(LogicException::class, 'nothing was applied');

        expect($evaluation->refresh()->isApplied())->toBeFalse();
    });

    it('does not touch an order that was finished before the revert', function () {
        $order = azOrder($this);
        $evaluation = azEvaluation($this);
        app(PriorityApplier::class)->apply($evaluation, 1);

        DB::table('manufacturing_orders')->where('id', $order->id)->update(['state' => 'done']);

        expect(app(PriorityApplier::class)->revert($evaluation))->toBe(0)
            ->and(azPriority($order))->toBe(ManufacturingOrderPriority::URGENT)
            ->and($evaluation->refresh()->isApplied())->toBeFalse();
    });

    it('applies the evaluation that the person saw on the work panel, not a newer one', function () {
        $order = azOrder($this);
        $seen = azEvaluation($this);
        $newer = azEvaluation($this);

        azSignIn(ProductionRoles::MANAGER);

        Livewire::test(WorkPanel::class)
            ->callAction('applyPriority', ['top_n' => 1], ['evaluation' => $seen->id]);

        expect(azPriority($order))->toBe(ManufacturingOrderPriority::NORMAL)
            ->and($seen->refresh()->isApplied())->toBeFalse()
            ->and($newer->refresh()->isApplied())->toBeFalse();

        Livewire::test(WorkPanel::class)
            ->callAction('applyPriority', ['top_n' => 1], ['evaluation' => $newer->id]);

        expect(azPriority($order))->toBe(ManufacturingOrderPriority::URGENT)
            ->and($newer->refresh()->isApplied())->toBeTrue();
    });
});

describe('order attributes and the sales order link', function () {
    it('are hidden from a user without the ability to set them', function () {
        $order = azOrder($this);

        azSignIn(ProductionRoles::SUPERVISOR);

        Livewire::test(ListOrderMonitoring::class)
            ->assertTableActionHidden('editAttributes', $order);
    });

    it('are open to a manager', function () {
        $order = azOrder($this);

        azSignIn(ProductionRoles::MANAGER);

        Livewire::test(ListOrderMonitoring::class)
            ->assertTableActionVisible('editAttributes', $order);
    });

    it('refuse a value that does not fit the column', function () {
        $order = azOrder($this);

        Livewire::test(ListOrderMonitoring::class)
            ->callTableAction('editAttributes', $order, ['urgency_level' => 3, 'order_value' => OrderAttribute::MAX_ORDER_VALUE + 1])
            ->assertHasTableActionErrors(['order_value']);

        expect(fn () => OrderAttribute::factory()->create(['manufacturing_order_id' => $order->id, 'order_value' => OrderAttribute::MAX_ORDER_VALUE + 1]))
            ->toThrow(InvalidArgumentException::class);
    });

    it('set the deadline of the order, which the time-to-deadline criterion reads', function () {
        $order = azOrder($this);

        Livewire::test(ListOrderMonitoring::class)
            ->callTableAction('editAttributes', $order, ['urgency_level' => 3, 'deadline_at' => '2026-12-20 16:00'])
            ->assertHasNoTableActionErrors();

        expect($order->refresh()->deadline_at->format('Y-m-d H:i'))->toBe('2026-12-20 16:00');
    });

    it('can not link a sales order that is not confirmed', function () {
        $order = azOrder($this);
        $draft = SaleHelper::order(['state' => SaleOrderState::DRAFT]);

        Livewire::test(ListOrderMonitoring::class)
            ->callTableAction('editAttributes', $order, ['urgency_level' => 3, 'sale_order_id' => $draft->id])
            ->assertHasTableActionErrors(['sale_order_id']);

        expect(OrderAttribute::query()->where('manufacturing_order_id', $order->id)->exists())->toBeFalse();
    });

    it('ignores the link from a user who may not read sales orders', function () {
        $order = azOrder($this);
        $sale = SaleHelper::order(['state' => SaleOrderState::SALE]);

        azSignIn(permissions: [
            'view_any_manufacturing_manufacturing::order', 'view_manufacturing_manufacturing::order',
            'update_manufacturing_manufacturing::order', Abilities::SET_ORDER_ATTRIBUTES,
        ]);

        Livewire::test(ListOrderMonitoring::class)
            ->callTableAction('editAttributes', $order, ['urgency_level' => 4, 'sale_order_id' => $sale->id]);

        $attribute = OrderAttribute::query()->where('manufacturing_order_id', $order->id)->first();

        expect($attribute->urgency_level)->toBe(4)
            ->and($attribute->sale_order_id)->toBeNull();
    });

    it('keeps the sales order link when a user without sales rights edits the urgency', function () {
        $order = azOrder($this);
        $sale = SaleHelper::order(['state' => SaleOrderState::SALE]);
        OrderAttribute::factory()->create(['manufacturing_order_id' => $order->id, 'sale_order_id' => $sale->id]);

        azSignIn(permissions: [
            'view_any_manufacturing_manufacturing::order', 'view_manufacturing_manufacturing::order',
            'update_manufacturing_manufacturing::order', Abilities::SET_ORDER_ATTRIBUTES,
        ]);

        Livewire::test(ListOrderMonitoring::class)
            ->callTableAction('editAttributes', $order, ['urgency_level' => 2]);

        expect(OrderAttribute::query()->where('manufacturing_order_id', $order->id)->value('sale_order_id'))->toBe($sale->id);
    });

    it('show neither the sales order value nor the customer to a user who may not read sales orders', function () {
        $order = azOrder($this);
        $sale = SaleHelper::compute(tap(SaleHelper::order(['state' => SaleOrderState::SALE]), fn ($saleOrder) => SaleHelper::line($saleOrder, $this->finished, 2, 1000000)));
        OrderAttribute::factory()->create(['manufacturing_order_id' => $order->id, 'sale_order_id' => $sale->id, 'order_value' => null]);

        $allowed = app(OrderValueResolver::class)->forOrder($order->refresh());
        $hidden = app(OrderValueResolver::class)->forOrder($order->refresh(), includeSales: false);

        expect($allowed->amount)->toBe(2000000.0)
            ->and($hidden->amount)->toBeNull()
            ->and($hidden->customerName)->toBeNull()
            ->and($hidden->salesOrderName)->toBeNull();

        azSignIn(ProductionRoles::SUPERVISOR);

        $report = app(OrderMonitoringReportBuilder::class)->build(new Collection([$order->refresh()]));

        expect($report->rows[0][9])->toBeNull()
            ->and($report->rows[0][11])->toBeNull();
    });
});

describe('exports', function () {
    it('are hidden from a user without the export ability', function () {
        azSignIn(ProductionRoles::WAREHOUSE, permissions: ['page_production_priority_daily_report', 'view_any_manufacturing_work::order']);

        Livewire::test(DailyProductionReport::class)
            ->assertActionHidden('exportExcel')
            ->assertActionHidden('exportPdf');
    });

    it('are shown to a user with the export ability', function () {
        azSignIn(ProductionRoles::SUPERVISOR);

        Livewire::test(DailyProductionReport::class)
            ->assertActionVisible('exportExcel')
            ->assertActionVisible('exportPdf');
    });

    it('do not show the values of hidden orders in the ranking', function () {
        $visible = azOrder($this, 2);
        $hidden = azOrder($this, 4);
        OrderAttribute::factory()->orderValue(777000000)->create(['manufacturing_order_id' => $hidden->id]);
        $evaluation = azEvaluation($this);

        $user = azSignIn(ProductionRoles::LEADER, scope: PermissionType::INDIVIDUAL);
        DB::table('manufacturing_orders')->where('id', $visible->id)->update(['assigned_user_id' => $user->id]);
        azForgetRange();

        $report = app(PriorityRankingReportBuilder::class)->build($evaluation->fresh());

        $rows = collect($report->rows);
        $hiddenRow = $rows->first(fn (array $row): bool => $row[1] === null);
        $visibleRow = $rows->first(fn (array $row): bool => $row[1] === $visible->name);

        expect($hiddenRow)->not->toBeNull()
            ->and(array_slice($hiddenRow, 5))->each->toBeNull()
            ->and(collect($visibleRow)->slice(5)->filter(fn ($value) => $value !== null))->not->toBeEmpty()
            ->and(json_encode($report->rows))->not->toContain('777000000');
    });

    it('show nothing of hidden orders on the evaluation page', function () {
        $visible = azOrder($this, 2);
        $hidden = azOrder($this, 4);
        OrderAttribute::factory()->orderValue(777000000)->create(['manufacturing_order_id' => $hidden->id]);
        $evaluation = azEvaluation($this);

        $user = azSignIn(ProductionRoles::LEADER, scope: PermissionType::INDIVIDUAL);
        DB::table('manufacturing_orders')->where('id', $visible->id)->update(['assigned_user_id' => $user->id]);
        azForgetRange();

        Livewire::test(ViewEvaluation::class, ['record' => $evaluation->getKey()])
            ->assertSuccessful()
            ->assertSee($visible->name)
            ->assertDontSee($hidden->name)
            ->assertDontSee('777,000,000');
    });
});

describe('criteria weights', function () {
    it('are normalised for the company of the user only', function () {
        $other = Company::factory()->create();

        $foreign = Criterion::withoutGlobalScopes()->create([
            'company_id' => $other->id,
            'code'       => 'C1',
            'name'       => 'Foreign criterion',
            'type'       => 'benefit',
            'source'     => 'urgency_level',
            'weight'     => 0.2,
            'is_active'  => true,
            'sort'       => 1,
        ]);

        Criterion::withoutGlobalScopes()->where('company_id', $this->company->id)->first()->update(['weight' => 0.5]);

        Livewire::test(ListCriteria::class)->callAction('normalizeWeights');

        $own = Criterion::withoutGlobalScopes()->where('company_id', $this->company->id)->where('is_active', true)->sum('weight');

        expect(round((float) $own, 4))->toBe(1.0)
            ->and((float) $foreign->refresh()->weight)->toBe(0.2);
    });
});
