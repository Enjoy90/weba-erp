<?php

namespace Weba\ProductionPriority\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Weba\ProductionPriority\Enums\EvaluationTrigger;
use Weba\ProductionPriority\Models\Evaluation;
use Weba\ProductionPriority\Models\OrderAttribute;
use Weba\ProductionPriority\Services\EvaluationService;
use Webkul\Inventory\Facades\Inventory;
use Webkul\Inventory\Models\OperationType;
use Webkul\Inventory\Models\ProductQuantity;
use Webkul\Manufacturing\Enums\BillOfMaterialConsumption;
use Webkul\Manufacturing\Enums\ManufacturingOrderState;
use Webkul\Manufacturing\Enums\OperationTimeMode;
use Webkul\Manufacturing\Facades\Manufacturing;
use Webkul\Manufacturing\Models\BillOfMaterial;
use Webkul\Manufacturing\Models\BillOfMaterialLine;
use Webkul\Manufacturing\Models\Move;
use Webkul\Manufacturing\Models\Operation;
use Webkul\Manufacturing\Models\Order;
use Webkul\Manufacturing\Models\Warehouse;
use Webkul\Manufacturing\Models\WorkCenter;
use Webkul\Manufacturing\Models\WorkOrder;
use Webkul\Manufacturing\Settings\OperationSettings;
use Webkul\Product\Models\Category;
use Webkul\Product\Models\Product;
use Webkul\Security\Models\User;
use Webkul\Support\Models\Company;
use Webkul\Support\Models\UOM;

/**
 * Demo data for a footwear factory (PT. Weba International case study): raw materials,
 * shoe articles with a bill of materials over five production stages, stock, and thirty
 * manufacturing orders in every state, followed by one SAW evaluation.
 *
 * All values are fictional and only meant to exercise the monitoring and SAW features.
 * Run with: php artisan db:seed --class="Weba\ProductionPriority\Database\Seeders\DemoDataSeeder"
 */
class DemoDataSeeder extends Seeder
{
    public const MARKER_REFERENCE = 'WEBA-RUN';

    /**
     * @var array<string, array{name: string, cost: float, stock: float}>
     */
    protected const MATERIALS = [
        'KLT' => ['name' => 'Kulit sintetis (lembar)', 'cost' => 18000, 'stock' => 6000],
        'BNG' => ['name' => 'Benang jahit (gulung)', 'cost' => 9000, 'stock' => 6000],
        'LNG' => ['name' => 'Kain lining (meter)', 'cost' => 12000, 'stock' => 6000],
        'INS' => ['name' => 'Insole EVA (pasang)', 'cost' => 7500, 'stock' => 6000],
        'SOL' => ['name' => 'Sol PU (pasang)', 'cost' => 22000, 'stock' => 1500],
        'LEM' => ['name' => 'Lem sepatu (kaleng)', 'cost' => 35000, 'stock' => 6000],
        'TLI' => ['name' => 'Tali sepatu (pasang)', 'cost' => 2500, 'stock' => 6000],
        'KTK' => ['name' => 'Kotak sepatu', 'cost' => 3000, 'stock' => 6000],
    ];

    /**
     * Minutes per cycle of ten pairs.
     *
     * @var array<string, array{name: string, code: string, cycle: float, cost_per_hour: float}>
     */
    protected const STAGES = [
        'STC' => ['name' => 'Stitching (Jahit Upper)', 'code' => 'STC', 'cycle' => 25, 'cost_per_hour' => 45000],
        'STB' => ['name' => 'Strobel', 'code' => 'STB', 'cycle' => 12, 'cost_per_hour' => 40000],
        'LST' => ['name' => 'Lasting', 'code' => 'LST', 'cycle' => 20, 'cost_per_hour' => 42000],
        'INJ' => ['name' => 'Injection (Injeksi Sol)', 'code' => 'INJ', 'cycle' => 15, 'cost_per_hour' => 60000],
        'FIN' => ['name' => 'Finishing', 'code' => 'FIN', 'cycle' => 18, 'cost_per_hour' => 38000],
    ];

    /**
     * Components per pair.
     *
     * @var array<string, array{name: string, price: float, components: array<string, float>}>
     */
    protected const ARTICLES = [
        'RUN' => ['name' => 'Sepatu Weba Runner', 'price' => 285000, 'components' => ['KLT' => 0.5, 'BNG' => 0.05, 'LNG' => 0.4, 'INS' => 1, 'SOL' => 1, 'LEM' => 0.02, 'TLI' => 1, 'KTK' => 1]],
        'CRT' => ['name' => 'Sepatu Weba Court', 'price' => 245000, 'components' => ['KLT' => 0.6, 'BNG' => 0.05, 'LNG' => 0.4, 'INS' => 1, 'SOL' => 1, 'LEM' => 0.02, 'TLI' => 1, 'KTK' => 1]],
        'TRL' => ['name' => 'Sepatu Weba Trail', 'price' => 325000, 'components' => ['KLT' => 0.7, 'BNG' => 0.06, 'LNG' => 0.5, 'INS' => 1, 'SOL' => 1, 'LEM' => 0.03, 'TLI' => 1, 'KTK' => 1]],
        'CSL' => ['name' => 'Sepatu Weba Casual Slip-On', 'price' => 215000, 'components' => ['KLT' => 0.45, 'BNG' => 0.04, 'LNG' => 0.4, 'INS' => 1, 'SOL' => 1, 'LEM' => 0.02, 'KTK' => 1]],
    ];

    /**
     * One row per manufacturing order.
     * deadline: days from today (negative = already late, null = no deadline).
     * done: number of finished stages; running: whether the next stage is in progress.
     * value: whether the order value is filled in; reserve: whether the materials are reserved.
     *
     * @var list<array{article: string, qty: int, state: string, started: int, deadline: int|null, urgency: int, value: bool, reserve: bool, done: int, running: bool}>
     */
    protected const ORDERS = [
        ['article' => 'RUN', 'qty' => 240, 'state' => 'progress', 'started' => -9, 'deadline' => -2, 'urgency' => 5, 'value' => true, 'reserve' => true, 'done' => 3, 'running' => true],
        ['article' => 'TRL', 'qty' => 150, 'state' => 'progress', 'started' => -6, 'deadline' => 1, 'urgency' => 5, 'value' => true, 'reserve' => true, 'done' => 2, 'running' => true],
        ['article' => 'CRT', 'qty' => 300, 'state' => 'progress', 'started' => -7, 'deadline' => 3, 'urgency' => 4, 'value' => true, 'reserve' => true, 'done' => 4, 'running' => false],
        ['article' => 'CSL', 'qty' => 120, 'state' => 'progress', 'started' => -4, 'deadline' => 5, 'urgency' => 3, 'value' => true, 'reserve' => true, 'done' => 1, 'running' => true],
        ['article' => 'RUN', 'qty' => 180, 'state' => 'progress', 'started' => -5, 'deadline' => 7, 'urgency' => 2, 'value' => true, 'reserve' => true, 'done' => 2, 'running' => false],
        ['article' => 'TRL', 'qty' => 90, 'state' => 'progress', 'started' => -3, 'deadline' => 9, 'urgency' => 4, 'value' => true, 'reserve' => true, 'done' => 1, 'running' => false],
        ['article' => 'CRT', 'qty' => 210, 'state' => 'progress', 'started' => -8, 'deadline' => -1, 'urgency' => 3, 'value' => true, 'reserve' => true, 'done' => 3, 'running' => false],
        ['article' => 'CSL', 'qty' => 160, 'state' => 'progress', 'started' => -2, 'deadline' => 12, 'urgency' => 2, 'value' => true, 'reserve' => true, 'done' => 0, 'running' => true],
        ['article' => 'RUN', 'qty' => 60, 'state' => 'progress', 'started' => -2, 'deadline' => 4, 'urgency' => 5, 'value' => true, 'reserve' => true, 'done' => 1, 'running' => true],
        ['article' => 'TRL', 'qty' => 200, 'state' => 'progress', 'started' => -6, 'deadline' => 6, 'urgency' => 3, 'value' => false, 'reserve' => true, 'done' => 2, 'running' => true],
        ['article' => 'CRT', 'qty' => 140, 'state' => 'to_close', 'started' => -10, 'deadline' => 2, 'urgency' => 3, 'value' => true, 'reserve' => true, 'done' => 5, 'running' => false],
        ['article' => 'CSL', 'qty' => 100, 'state' => 'to_close', 'started' => -9, 'deadline' => 0, 'urgency' => 2, 'value' => true, 'reserve' => true, 'done' => 5, 'running' => false],
        ['article' => 'RUN', 'qty' => 220, 'state' => 'confirmed', 'started' => 1, 'deadline' => 8, 'urgency' => 4, 'value' => true, 'reserve' => true, 'done' => 0, 'running' => false],
        ['article' => 'TRL', 'qty' => 130, 'state' => 'confirmed', 'started' => 1, 'deadline' => 4, 'urgency' => 5, 'value' => true, 'reserve' => true, 'done' => 0, 'running' => false],
        ['article' => 'CRT', 'qty' => 260, 'state' => 'confirmed', 'started' => 2, 'deadline' => 14, 'urgency' => 2, 'value' => true, 'reserve' => true, 'done' => 0, 'running' => false],
        ['article' => 'CSL', 'qty' => 80, 'state' => 'confirmed', 'started' => 0, 'deadline' => -3, 'urgency' => 4, 'value' => true, 'reserve' => true, 'done' => 0, 'running' => false],
        ['article' => 'RUN', 'qty' => 300, 'state' => 'confirmed', 'started' => 3, 'deadline' => 20, 'urgency' => 1, 'value' => true, 'reserve' => true, 'done' => 0, 'running' => false],
        ['article' => 'TRL', 'qty' => 170, 'state' => 'confirmed', 'started' => 2, 'deadline' => 10, 'urgency' => 3, 'value' => true, 'reserve' => true, 'done' => 0, 'running' => false],
        ['article' => 'CRT', 'qty' => 110, 'state' => 'confirmed', 'started' => 1, 'deadline' => 6, 'urgency' => 3, 'value' => true, 'reserve' => false, 'done' => 0, 'running' => false],
        ['article' => 'CSL', 'qty' => 190, 'state' => 'confirmed', 'started' => 4, 'deadline' => 18, 'urgency' => 2, 'value' => true, 'reserve' => false, 'done' => 0, 'running' => false],
        ['article' => 'RUN', 'qty' => 75, 'state' => 'confirmed', 'started' => 0, 'deadline' => 2, 'urgency' => 4, 'value' => false, 'reserve' => false, 'done' => 0, 'running' => false],
        ['article' => 'TRL', 'qty' => 250, 'state' => 'confirmed', 'started' => 5, 'deadline' => null, 'urgency' => 3, 'value' => true, 'reserve' => true, 'done' => 0, 'running' => false],
        ['article' => 'CRT', 'qty' => 95, 'state' => 'confirmed', 'started' => 2, 'deadline' => 9, 'urgency' => 1, 'value' => true, 'reserve' => false, 'done' => 0, 'running' => false],
        ['article' => 'RUN', 'qty' => 160, 'state' => 'draft', 'started' => 6, 'deadline' => 21, 'urgency' => 3, 'value' => true, 'reserve' => false, 'done' => 0, 'running' => false],
        ['article' => 'CSL', 'qty' => 140, 'state' => 'draft', 'started' => 7, 'deadline' => 25, 'urgency' => 2, 'value' => true, 'reserve' => false, 'done' => 0, 'running' => false],
        ['article' => 'TRL', 'qty' => 60, 'state' => 'draft', 'started' => 5, 'deadline' => 15, 'urgency' => 4, 'value' => true, 'reserve' => false, 'done' => 0, 'running' => false],
        ['article' => 'CRT', 'qty' => 180, 'state' => 'done', 'started' => -20, 'deadline' => -10, 'urgency' => 3, 'value' => true, 'reserve' => true, 'done' => 5, 'running' => false],
        ['article' => 'RUN', 'qty' => 120, 'state' => 'done', 'started' => -18, 'deadline' => -8, 'urgency' => 4, 'value' => true, 'reserve' => true, 'done' => 5, 'running' => false],
        ['article' => 'CSL', 'qty' => 90, 'state' => 'done', 'started' => -15, 'deadline' => -5, 'urgency' => 2, 'value' => true, 'reserve' => true, 'done' => 5, 'running' => false],
        ['article' => 'TRL', 'qty' => 70, 'state' => 'done', 'started' => -14, 'deadline' => -4, 'urgency' => 3, 'value' => true, 'reserve' => true, 'done' => 5, 'running' => false],
    ];

    protected Company $company;

    protected UOM $units;

    protected Warehouse $warehouse;

    /**
     * The demo orders have work orders, and the work orders page, the work
     * center load and the work orders menu item only exist while this setting
     * is on. A fresh installation leaves it off.
     */
    protected function enableWorkOrders(): void
    {
        $settings = settings(OperationSettings::class);

        if (! $settings->enable_work_orders) {
            $settings->enable_work_orders = true;
            $settings->save();
        }
    }

    public function run(): void
    {
        $this->enableWorkOrders();

        if (Product::query()->where('reference', self::MARKER_REFERENCE)->exists()) {
            $this->command?->warn('Data demo sudah ada, seeder dilewati.');

            return;
        }

        Auth::setUser(User::query()->orderBy('id')->firstOrFail());

        $this->company = Company::query()->orderBy('id')->firstOrFail();
        $this->units = UOM::query()->where('name', 'Units')->firstOrFail();
        $this->warehouse = Warehouse::query()->whereNotNull('manu_type_id')->orderBy('id')->firstOrFail();

        $evaluation = $this->withMassAssignmentProtection(fn (): ?Evaluation => DB::transaction(function (): ?Evaluation {
            $materials = $this->createMaterials();
            $workCenters = $this->createWorkCenters();
            $boms = $this->createArticles($materials, $workCenters);

            $this->stockMaterials($materials);

            foreach (self::ORDERS as $position => $spec) {
                $this->createOrder($position + 1, $spec, $boms[$spec['article']]);
            }

            return app(EvaluationService::class)->run($this->company->id, EvaluationTrigger::MANUAL, 'Evaluasi data demo');
        }));

        $this->command?->info(sprintf(
            'Data demo dibuat: %d bahan, %d work center, %d artikel, %d order produksi, evaluasi SAW dengan %d order.',
            count(self::MATERIALS),
            count(self::STAGES),
            count(self::ARTICLES),
            count(self::ORDERS),
            $evaluation?->order_count ?? 0,
        ));
    }

    /**
     * Seeders run unguarded, but the manufacturing models pass helper attributes
     * (for example propagate_cancel) that only $fillable filters out of the insert.
     *
     * @template TResult
     *
     * @param  callable(): TResult  $callback
     * @return TResult
     */
    protected function withMassAssignmentProtection(callable $callback): mixed
    {
        $wasUnguarded = Model::isUnguarded();

        Model::reguard();

        try {
            return $callback();
        } finally {
            if ($wasUnguarded) {
                Model::unguard();
            }
        }
    }

    /**
     * @return array<string, Product>
     */
    protected function createMaterials(): array
    {
        $materials = [];

        foreach (self::MATERIALS as $code => $material) {
            $materials[$code] = $this->createProduct('WEBA-'.$code, $material['name'], 0, $material['cost']);
        }

        return $materials;
    }

    /**
     * @return array<string, WorkCenter>
     */
    protected function createWorkCenters(): array
    {
        $workCenters = [];

        foreach (self::STAGES as $key => $stage) {
            $workCenters[$key] = WorkCenter::factory()->create([
                'name'             => $stage['name'],
                'code'             => $stage['code'],
                'note'             => null,
                'time_efficiency'  => 100,
                'default_capacity' => 10,
                'costs_per_hour'   => $stage['cost_per_hour'],
                'setup_time'       => 10,
                'cleanup_time'     => 5,
                'oee_target'       => 85,
                'company_id'       => $this->company->id,
            ]);
        }

        return $workCenters;
    }

    /**
     * @param  array<string, Product>  $materials
     * @param  array<string, WorkCenter>  $workCenters
     * @return array<string, BillOfMaterial>
     */
    protected function createArticles(array $materials, array $workCenters): array
    {
        $boms = [];

        foreach (self::ARTICLES as $code => $article) {
            $product = $this->createProduct('WEBA-'.$code, $article['name'], $article['price'], 0);

            $bom = BillOfMaterial::factory()->create([
                'product_id'  => $product->id,
                'uom_id'      => $this->units->id,
                'quantity'    => 1,
                'consumption' => BillOfMaterialConsumption::FLEXIBLE,
                'company_id'  => $this->company->id,
            ]);

            foreach ($article['components'] as $materialCode => $quantity) {
                BillOfMaterialLine::create([
                    'bill_of_material_id' => $bom->id,
                    'product_id'          => $materials[$materialCode]->id,
                    'uom_id'              => $this->units->id,
                    'quantity'            => $quantity,
                    'company_id'          => $this->company->id,
                ]);
            }

            $sort = 1;

            foreach (self::STAGES as $key => $stage) {
                Operation::factory()->create([
                    'bill_of_material_id' => $bom->id,
                    'work_center_id'      => $workCenters[$key]->id,
                    'name'                => $stage['name'],
                    'note'                => null,
                    'sort'                => $sort++,
                    'time_mode'           => OperationTimeMode::MANUAL,
                    'manual_cycle_time'   => $stage['cycle'],
                ]);
            }

            $boms[$code] = $bom->refresh();
        }

        return $boms;
    }

    /**
     * @param  array<string, Product>  $materials
     */
    protected function stockMaterials(array $materials): void
    {
        foreach (self::MATERIALS as $code => $material) {
            ProductQuantity::factory()->create([
                'product_id'              => $materials[$code]->id,
                'location_id'             => $this->warehouse->lot_stock_location_id,
                'quantity'                => $material['stock'],
                'inventory_diff_quantity' => $material['stock'],
                'company_id'              => $this->company->id,
            ]);
        }
    }

    protected function createProduct(string $reference, string $name, float $price, float $cost): Product
    {
        return Product::factory()->create([
            'reference'            => $reference,
            'name'                 => $name,
            'price'                => $price,
            'cost'                 => $cost,
            'description'          => null,
            'description_purchase' => null,
            'description_sale'     => null,
            'is_storable'          => true,
            'category_id'          => Category::query()->orderBy('id')->value('id'),
            'uom_id'               => $this->units->id,
            'uom_po_id'            => $this->units->id,
            'company_id'           => $this->company->id,
        ]);
    }

    /**
     * @param  array{article: string, qty: int, state: string, started: int, deadline: int|null, urgency: int, value: bool, reserve: bool, done: int, running: bool}  $spec
     */
    protected function createOrder(int $number, array $spec, BillOfMaterial $bom): void
    {
        $operationType = OperationType::query()->findOrFail($this->warehouse->manu_type_id);

        $order = Order::factory()->create([
            'reference'               => sprintf('WEBA/MO/%04d', $number),
            'origin'                  => 'Data demo',
            'state'                   => ManufacturingOrderState::DRAFT,
            'consumption'             => BillOfMaterialConsumption::FLEXIBLE,
            'product_id'              => $bom->product_id,
            'uom_id'                  => $this->units->id,
            'bill_of_material_id'     => $bom->id,
            'quantity'                => $spec['qty'],
            'quantity_producing'      => 0,
            'started_at'              => now()->addDays($spec['started'])->setTime(8, 0),
            'deadline_at'             => $spec['deadline'] === null ? null : now()->addDays($spec['deadline'])->setTime(16, 0),
            'operation_type_id'       => $operationType->id,
            'source_location_id'      => $operationType->source_location_id,
            'destination_location_id' => $operationType->destination_location_id,
            'company_id'              => $this->company->id,
        ]);

        $order->refresh()->computeFinishedMoves();

        foreach ($order->getMovesRawValues() as $values) {
            Move::create($values);
        }

        $this->createWorkOrders($order->refresh(), $bom);

        OrderAttribute::query()->create([
            'manufacturing_order_id' => $order->id,
            'urgency_level'          => $spec['urgency'],
            'order_value'            => $spec['value'] ? $spec['qty'] * self::ARTICLES[$spec['article']]['price'] : null,
        ]);

        if ($spec['state'] === 'draft') {
            return;
        }

        $order = Manufacturing::confirmManufacturingOrder($order->refresh());

        if ($spec['reserve']) {
            Inventory::reserveMoves($order->refresh()->rawMaterialMoves);
        }

        $this->progressWorkOrders($order->refresh(), $spec);

        if ($spec['state'] === 'done') {
            $order->refresh()->update(['quantity_producing' => $spec['qty']]);

            Manufacturing::doneManufacturingOrder($order->refresh());
        }
    }

    protected function createWorkOrders(Order $order, BillOfMaterial $bom): void
    {
        $product = $order->product;

        foreach ($bom->operations()->with('workCenter')->orderBy('sort')->get() as $operation) {
            WorkOrder::factory()->create([
                'name'                   => $operation->name,
                'manufacturing_order_id' => $order->id,
                'operation_id'           => $operation->id,
                'work_center_id'         => $operation->work_center_id,
                'product_id'             => $order->product_id,
                'uom_id'                 => $order->uom_id,
                'expected_duration'      => $operation->getExpectedDuration($product, (float) $order->quantity),
            ]);
        }
    }

    /**
     * Finishes the first stages with a realistic recorded duration and starts the next one.
     *
     * @param  array{article: string, qty: int, state: string, started: int, deadline: int|null, urgency: int, value: bool, reserve: bool, done: int, running: bool}  $spec
     */
    protected function progressWorkOrders(Order $order, array $spec): void
    {
        $workOrders = $order->workOrders()->orderBy('id')->get();
        $clock = now()->addDays($spec['started'])->setTime(8, 0);
        $speedFactors = [0.92, 1.08, 1.0, 1.15, 0.95];

        foreach ($workOrders as $index => $workOrder) {
            if ($index < $spec['done']) {
                $workOrder->refresh()->start();
                $workOrder->refresh()->finish();

                $minutes = round((float) $workOrder->expected_duration * $speedFactors[$index % count($speedFactors)], 2);

                $workOrder->refresh()->updateQuietly([
                    'started_at'  => $clock->copy(),
                    'finished_at' => $clock->copy()->addMinutes((int) $minutes),
                    'duration'    => $minutes,
                ]);

                $clock->addMinutes((int) $minutes);

                continue;
            }

            if ($index === $spec['done'] && $spec['running']) {
                $workOrder->refresh()->start();
            }

            break;
        }
    }
}
