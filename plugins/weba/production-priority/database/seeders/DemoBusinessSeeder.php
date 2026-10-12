<?php

namespace Weba\ProductionPriority\Database\Seeders;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Weba\ProductionPriority\Enums\EvaluationTrigger;
use Weba\ProductionPriority\Models\OrderAttribute;
use Weba\ProductionPriority\Services\EvaluationService;
use Webkul\Account\Enums\PaymentType;
use Webkul\Account\Facades\Account as AccountFacade;
use Webkul\Account\Models\Journal;
use Webkul\Account\Models\Move as AccountMove;
use Webkul\Account\Models\Partner;
use Webkul\Account\Models\PaymentRegister;
use Webkul\Account\Models\Tax;
use Webkul\Inventory\Enums\MoveState;
use Webkul\Inventory\Enums\OperationState;
use Webkul\Inventory\Enums\PackageUse;
use Webkul\Inventory\Enums\ProductTracking;
use Webkul\Inventory\Facades\Inventory;
use Webkul\Inventory\Models\Lot;
use Webkul\Inventory\Models\Operation;
use Webkul\Inventory\Models\Package;
use Webkul\Inventory\Models\Product as InventoryProduct;
use Webkul\Inventory\Models\ProductQuantity;
use Webkul\Inventory\Models\Warehouse;
use Webkul\Inventory\Settings\OperationSettings as InventoryOperationSettings;
use Webkul\Inventory\Settings\TraceabilitySettings;
use Webkul\Invoice\Models\BankAccount;
use Webkul\Manufacturing\Enums\ManufacturingOrderState;
use Webkul\Manufacturing\Models\Order as ManufacturingOrder;
use Webkul\Partner\Enums\AccountType;
use Webkul\PluginManager\Package as PluginPackage;
use Webkul\Product\Enums\ProductType;
use Webkul\Product\Models\Category;
use Webkul\Product\Models\Product;
use Webkul\Purchase\Enums\OrderState as PurchaseOrderState;
use Webkul\Purchase\Enums\QtyReceivedMethod;
use Webkul\Purchase\Enums\RequisitionState;
use Webkul\Purchase\Enums\RequisitionType;
use Webkul\Purchase\Facades\PurchaseOrder as PurchaseOrderFacade;
use Webkul\Purchase\Models\Order as PurchaseOrder;
use Webkul\Purchase\Models\ProductSupplier;
use Webkul\Purchase\Models\Requisition;
use Webkul\Purchase\Settings\OrderSettings as PurchaseOrderSettings;
use Webkul\Sale\Enums\AdvancedPayment;
use Webkul\Sale\Enums\OrderState as SaleOrderState;
use Webkul\Sale\Facades\SaleOrder as SaleOrderFacade;
use Webkul\Sale\Models\ActivityPlan;
use Webkul\Sale\Models\Order as SaleOrder;
use Webkul\Security\Models\Team;
use Webkul\Security\Models\User;
use Webkul\Support\Models\ActivityType;
use Webkul\Support\Models\Bank;
use Webkul\Support\Models\Company;
use Webkul\Support\Models\Country;
use Webkul\Support\Models\State;
use Webkul\Support\Models\UOM;

/**
 * The business around the demo factory: customers and suppliers, quotations and
 * sales orders (some delivered, invoiced and paid), requests for quotation and
 * purchase orders (some received and billed), vendor prices, a blanket order, lots,
 * packages, teams, an activity plan and a bank account. Everything goes through the
 * ERP's own services so the documents are consistent with each other.
 *
 * It expects DemoDataSeeder to have run (the shoe articles, the materials and the
 * manufacturing orders). Running it again changes nothing.
 */
class DemoBusinessSeeder extends Seeder
{
    public const MARKER_VENDOR = 'CV Sumber Kulit Nusantara';

    /**
     * @var array<string, array{name: string, city: string, state: string, zip: string, street: string, phone: string, email: string}>
     */
    protected const CUSTOMERS = [
        'maju'     => ['name' => 'Toko Sepatu Maju Jaya', 'city' => 'Bandung', 'state' => 'JB', 'zip' => '40111', 'street' => 'Jl. Braga No. 21', 'phone' => '022 4201 331', 'email' => 'order@majujaya.test'],
        'langkah'  => ['name' => 'CV Langkah Sehat', 'city' => 'Surabaya', 'state' => 'JI', 'zip' => '60271', 'street' => 'Jl. Tunjungan No. 88', 'phone' => '031 5470 129', 'email' => 'pembelian@langkahsehat.test'],
        'sport'    => ['name' => 'PT Sport Nusantara', 'city' => 'Jakarta Selatan', 'state' => 'JK', 'zip' => '12190', 'street' => 'Jl. Jend. Sudirman Kav. 52', 'phone' => '021 5550 1234', 'email' => 'procurement@sportnusantara.test'],
        'distro'   => ['name' => 'Distro Kaki Lima', 'city' => 'Yogyakarta', 'state' => 'YO', 'zip' => '55271', 'street' => 'Jl. Malioboro No. 5', 'phone' => '0274 512 776', 'email' => 'halo@kakilima.test'],
        'koperasi' => ['name' => 'Koperasi Karyawan Sejahtera', 'city' => 'Semarang', 'state' => 'JT', 'zip' => '50132', 'street' => 'Jl. Pemuda No. 150', 'phone' => '024 3541 870', 'email' => 'koperasi@sejahtera.test'],
    ];

    /**
     * @var array<string, array{name: string, city: string, state: string, zip: string, street: string, phone: string, email: string}>
     */
    protected const VENDORS = [
        'kulit'   => ['name' => self::MARKER_VENDOR, 'city' => 'Bandung', 'state' => 'JB', 'zip' => '40212', 'street' => 'Jl. Sukaregang No. 12', 'phone' => '022 6031 455', 'email' => 'sales@sumberkulit.test'],
        'sol'     => ['name' => 'PT Sol Indah Abadi', 'city' => 'Tangerang', 'state' => 'BT', 'zip' => '15111', 'street' => 'Kawasan Industri Jatake Blok C3', 'phone' => '021 5930 2211', 'email' => 'marketing@solindah.test'],
        'benang'  => ['name' => 'UD Benang Jaya', 'city' => 'Surakarta', 'state' => 'JT', 'zip' => '57111', 'street' => 'Jl. Slamet Riyadi No. 301', 'phone' => '0271 642 118', 'email' => 'benangjaya@mail.test'],
        'kemasan' => ['name' => 'PT Kemasan Prima', 'city' => 'Bekasi', 'state' => 'JB', 'zip' => '17530', 'street' => 'Jl. Industri Selatan 5 Blok GG', 'phone' => '021 8990 4512', 'email' => 'order@kemasanprima.test'],
    ];

    /**
     * Material reference => vendor key, price per unit.
     *
     * @var array<string, array{0: string, 1: float}>
     */
    protected const VENDOR_PRICES = [
        'WEBA-KLT' => ['kulit', 17500],
        'WEBA-LNG' => ['kulit', 11500],
        'WEBA-SOL' => ['sol', 21000],
        'WEBA-INS' => ['sol', 7200],
        'WEBA-BNG' => ['benang', 8800],
        'WEBA-TLI' => ['benang', 2400],
        'WEBA-KTK' => ['kemasan', 2900],
        'WEBA-LEM' => ['kemasan', 34000],
    ];

    protected Company $company;

    protected User $admin;

    protected Warehouse $warehouse;

    protected UOM $units;

    protected ?int $countryId;

    /**
     * @var array<string, Partner>
     */
    protected array $customers = [];

    /**
     * @var array<string, Partner>
     */
    protected array $vendors = [];

    public function run(): void
    {
        foreach (['sales', 'purchases', 'accounts', 'invoices', 'inventories'] as $plugin) {
            if (! PluginPackage::isPluginInstalled($plugin)) {
                $this->command?->warn("Plugin {$plugin} belum terpasang, data bisnis demo dilewati.");

                return;
            }
        }

        if (Partner::query()->where('name', self::MARKER_VENDOR)->exists()) {
            $this->command?->warn('Data bisnis demo sudah ada, seeder dilewati.');

            return;
        }

        if (! Product::query()->where('reference', 'WEBA-RUN')->exists()) {
            $this->command?->warn('Jalankan DemoDataSeeder lebih dulu.');

            return;
        }

        $this->admin = User::query()->orderBy('id')->firstOrFail();
        Auth::login($this->admin);
        URL::resolveMissingNamedRoutesUsing(fn () => '#');

        $this->company = Company::query()->orderBy('id')->firstOrFail();
        $this->warehouse = Warehouse::query()->where('company_id', $this->company->id)->orderBy('id')->firstOrFail();
        $this->units = UOM::query()->where('name', 'Units')->firstOrFail();
        $this->countryId = Country::query()->where('code', 'ID')->value('id');

        $this->enableSettings();

        $wasUnguarded = Model::isUnguarded();
        Model::reguard();

        try {
            DB::transaction(function (): void {
                $this->createPartners();
                $this->createPurchasing();
                $this->createSales();
                $this->createLotsAndPackages();
                $this->createSettingsRecords();
            });
        } finally {
            if ($wasUnguarded) {
                Model::unguard();
            }
        }

        app(EvaluationService::class)->run($this->company->id, EvaluationTrigger::MANUAL, 'Evaluasi setelah data penjualan');

        $this->command?->info('Data bisnis demo dibuat: pelanggan, pemasok, penjualan, pembelian, faktur, pembayaran, lot, paket, tim.');
    }

    protected function enableSettings(): void
    {
        foreach ([
            [TraceabilitySettings::class, 'enable_lots_serial_numbers'],
            [InventoryOperationSettings::class, 'enable_packages'],
            [PurchaseOrderSettings::class, 'enable_purchase_agreements'],
        ] as [$class, $property]) {
            $settings = app($class);

            if (! $settings->{$property}) {
                $settings->{$property} = true;
                $settings->save();
            }
        }
    }

    protected function createPartners(): void
    {
        foreach (self::CUSTOMERS as $key => $data) {
            $this->customers[$key] = $this->partner($data, ['customer_rank' => 1]);
        }

        foreach (self::VENDORS as $key => $data) {
            $this->vendors[$key] = $this->partner($data, ['supplier_rank' => 1]);
        }
    }

    /**
     * @param  array{name: string, city: string, state: string, zip: string, street: string, phone: string, email: string}  $data
     * @param  array<string, int>  $ranks
     */
    protected function partner(array $data, array $ranks): Partner
    {
        return Partner::query()->create([
            'account_type' => AccountType::COMPANY,
            'name'         => $data['name'],
            'email'        => $data['email'],
            'phone'        => $data['phone'],
            'street1'      => $data['street'],
            'city'         => $data['city'],
            'zip'          => $data['zip'],
            'state_id'     => State::query()->where('country_id', $this->countryId)->where('code', $data['state'])->value('id'),
            'country_id'   => $this->countryId,
            'creator_id'   => $this->admin->id,
            'user_id'      => $this->admin->id,
            ...$ranks,
        ]);
    }

    protected function product(string $reference): Product
    {
        return Product::query()->where('reference', $reference)->firstOrFail();
    }

    /**
     * The 11% VAT that IndonesianTaxSeeder created, or none when it is missing.
     *
     * @return list<int>
     */
    protected function vat(string $use): array
    {
        return Tax::query()
            ->where('company_id', $this->company->id)
            ->where('type_tax_use', $use)
            ->where('name', IndonesianTaxSeeder::NAME)
            ->pluck('id')
            ->all();
    }

    /* ------------------------------------------------------------ pembelian */

    protected function createPurchasing(): void
    {
        foreach (self::VENDOR_PRICES as $reference => [$vendor, $price]) {
            ProductSupplier::query()->create([
                'partner_id'   => $this->vendors[$vendor]->id,
                'product_id'   => $this->product($reference)->id,
                'currency_id'  => $this->company->currency_id,
                'min_qty'      => 50,
                'price'        => $price,
                'delay'        => 5,
                'product_code' => $reference.'-SUP',
            ]);
        }

        $agreement = Requisition::query()->create([
            'type'        => RequisitionType::BLANKET_ORDER,
            'state'       => RequisitionState::DRAFT,
            'partner_id'  => $this->vendors['sol']->id,
            'currency_id' => $this->company->currency_id,
            'company_id'  => $this->company->id,
            'user_id'     => $this->admin->id,
            'reference'   => 'KONTRAK-SOL-2026',
            'starts_at'   => now()->startOfYear(),
            'ends_at'     => now()->endOfYear(),
            'description' => 'Kontrak tahunan sol PU dengan harga tetap.',
        ]);
        $agreement->lines()->create([
            'product_id' => $this->product('WEBA-SOL')->id,
            'uom_id'     => $this->units->id,
            'qty'        => 5000,
            'price_unit' => 21000,
            'company_id' => $this->company->id,
        ]);
        $agreement->update(['state' => RequisitionState::CONFIRMED]);

        $paid = $this->purchaseOrder('kulit', [['WEBA-KLT', 500, 17500], ['WEBA-LNG', 300, 11500]], now()->subDays(18));
        $this->confirmReceiveAndBill($paid, now()->subDays(12), pay: true);

        $billed = $this->purchaseOrder('sol', [['WEBA-SOL', 800, 21000]], now()->subDays(9));
        $this->confirmReceiveAndBill($billed, now()->subDays(4), pay: false);

        $returned = $this->purchaseOrder('benang', [['WEBA-BNG', 60, 8800]], now()->subDays(15));
        $bill = $this->confirmReceiveAndBill($returned, now()->subDays(10), pay: false);
        AccountFacade::confirmMove(AccountFacade::reverseMoves(collect([$bill->refresh()]))->first()->refresh());

        PurchaseOrderFacade::confirmPurchaseOrder($this->purchaseOrder('kemasan', [['WEBA-KTK', 1000, 2900], ['WEBA-LEM', 40, 34000]], now()->subDays(2))->refresh());

        $this->purchaseOrder('benang', [['WEBA-BNG', 200, 8800], ['WEBA-TLI', 500, 2400]], now()->subDay());
        $this->purchaseOrder('kulit', [['WEBA-KLT', 400, 17500]], now())->update(['state' => PurchaseOrderState::SENT]);
    }

    /**
     * @param  list<array{0: string, 1: float, 2: float}>  $lines  reference, quantity, unit price
     */
    protected function purchaseOrder(string $vendor, array $lines, CarbonInterface $date): PurchaseOrder
    {
        $order = PurchaseOrder::query()->create([
            'partner_id'        => $this->vendors[$vendor]->id,
            'currency_id'       => $this->company->currency_id,
            'company_id'        => $this->company->id,
            'ordered_at'        => $date,
            'user_id'           => $this->admin->id,
            'operation_type_id' => $this->warehouse->in_type_id,
            'state'             => PurchaseOrderState::DRAFT,
        ]);

        foreach ($lines as [$reference, $quantity, $price]) {
            $product = $this->product($reference);

            $line = $order->lines()->create([
                'name'                => $product->name,
                'product_id'          => $product->id,
                'uom_id'              => $product->uom_id,
                'product_qty'         => $quantity,
                'product_uom_qty'     => $quantity,
                'price_unit'          => $price,
                'discount'            => 0,
                'planned_at'          => $date->copy()->addDays(5),
                'qty_received_method' => QtyReceivedMethod::STOCK_MOVE,
                'partner_id'          => $order->partner_id,
                'currency_id'         => $order->currency_id,
                'company_id'          => $this->company->id,
            ]);
            $line->taxes()->sync($this->vat('purchase'));
        }

        return PurchaseOrderFacade::computePurchaseOrder($order->refresh());
    }

    protected function confirmReceiveAndBill(PurchaseOrder $order, CarbonInterface $billDate, bool $pay): AccountMove
    {
        $order = PurchaseOrderFacade::confirmPurchaseOrder($order->refresh());

        $this->completeOperations(fn () => $order->refresh()->load('operations.moves')->operations);

        PurchaseOrderFacade::createPurchaseOrderBill($order->refresh());

        $bill = $order->refresh()->accountMoves()->orderByDesc('id')->firstOrFail();
        $bill->update(['invoice_date' => $billDate]);
        $bill = AccountFacade::confirmMove($bill->refresh());

        if ($pay) {
            $this->registerPayment($bill, null, $billDate->copy()->addDays(3));
        }

        return $bill;
    }

    /* ------------------------------------------------------------ penjualan */

    protected function createSales(): void
    {
        $paid = $this->saleOrder('maju', [['WEBA-RUN', 60, 285000], ['WEBA-CRT', 80, 245000]], now()->subDays(14));
        $invoice = $this->confirmDeliverAndInvoice($paid, now()->subDays(10));
        $this->registerPayment($invoice, null, now()->subDays(6));

        $partly = $this->saleOrder('langkah', [['WEBA-TRL', 40, 325000]], now()->subDays(11));
        $invoice = $this->confirmDeliverAndInvoice($partly, now()->subDays(7));
        $this->registerPayment($invoice, round((float) $invoice->amount_total / 2), now()->subDays(3));

        $credited = $this->saleOrder('sport', [['WEBA-CSL', 30, 215000]], now()->subDays(9));
        $invoice = $this->confirmDeliverAndInvoice($credited, now()->subDays(6));
        AccountFacade::confirmMove(AccountFacade::reverseMoves(collect([$invoice->refresh()]))->first()->refresh());

        $toInvoice = SaleOrderFacade::confirmSaleOrder($this->saleOrder('koperasi', [['WEBA-CSL', 20, 215000]], now()->subDays(5))->refresh());
        $this->completeOperations(fn () => $toInvoice->refresh()->load('operations.moves')->operations, onlyReady: true);

        $this->createUpsellOrder();

        $this->linkSalesOrdersToProduction();

        $this->saleOrder('distro', [['WEBA-TRL', 50, 325000], ['WEBA-RUN', 50, 285000]], now()->subDays(2));
        $this->saleOrder('koperasi', [['WEBA-CRT', 120, 240000]], now()->subDay())->update(['state' => SaleOrderState::SENT]);
        $this->saleOrder('sport', [['WEBA-CSL', 200, 210000]], now());
    }

    /**
     * @param  list<array{0: string, 1: float, 2: float}>  $lines  reference, quantity, unit price
     */
    protected function saleOrder(string $customer, array $lines, CarbonInterface $date): SaleOrder
    {
        $order = SaleOrder::query()->create([
            'partner_id'   => $this->customers[$customer]->id,
            'currency_id'  => $this->company->currency_id,
            'company_id'   => $this->company->id,
            'date_order'   => $date,
            'user_id'      => $this->admin->id,
            'warehouse_id' => $this->warehouse->id,
            'state'        => SaleOrderState::DRAFT,
        ]);

        foreach ($lines as [$reference, $quantity, $price]) {
            $product = $this->product($reference);

            $line = $order->lines()->create([
                'name'             => $product->name,
                'product_id'       => $product->id,
                'product_uom_id'   => $product->uom_id,
                'product_uom_qty'  => $quantity,
                'product_qty'      => $quantity,
                'price_unit'       => $price,
                'discount'         => 0,
                'customer_lead'    => 0,
                'company_id'       => $this->company->id,
                'currency_id'      => $order->currency_id,
                'order_partner_id' => $order->partner_id,
                'salesman_id'      => $this->admin->id,
            ]);
            $line->taxes()->sync($this->vat('sale'));
        }

        return SaleOrderFacade::computeSaleOrder($order->refresh());
    }

    protected function confirmDeliverAndInvoice(SaleOrder $order, CarbonInterface $invoiceDate): AccountMove
    {
        $order = SaleOrderFacade::confirmSaleOrder($order->refresh());

        $this->completeOperations(fn () => $order->refresh()->load('operations.moves')->operations, onlyReady: true);

        SaleOrderFacade::createInvoice($order->refresh(), ['advance_payment_method' => AdvancedPayment::DELIVERED->value]);

        $invoice = $order->refresh()->accountMoves()->orderByDesc('id')->firstOrFail();
        $invoice->update(['invoice_date' => $invoiceDate]);

        return AccountFacade::confirmMove($invoice->refresh());
    }

    /**
     * "Orders to upsell" lists orders that delivered more than was ordered on a
     * product invoiced by ordered quantity. Shoe laces sold as an accessory do that.
     */
    protected function createUpsellOrder(): void
    {
        $laces = $this->product('WEBA-TLI');
        $laces->update(['invoice_policy' => 'order']);

        $order = SaleOrderFacade::confirmSaleOrder($this->saleOrder('distro', [['WEBA-TLI', 100, 6000]], now()->subDays(4))->refresh());

        $order->refresh()->load('operations.moves');
        $operation = $order->operations->first(fn (Operation $operation): bool => $this->isReady($operation));

        if ($operation) {
            $operation->moves->first()?->update(['quantity' => 120]);
            Inventory::completeTransfer($operation->refresh());
        }

        SaleOrderFacade::computeSaleOrder($order->refresh());
    }

    /**
     * Five open manufacturing orders get a confirmed sales order for the same
     * article and quantity, so criterion C6 reads the value from the sale.
     */
    protected function linkSalesOrdersToProduction(): void
    {
        $customers = array_keys(self::CUSTOMERS);

        $orders = ManufacturingOrder::query()
            ->whereIn('state', [ManufacturingOrderState::CONFIRMED, ManufacturingOrderState::PROGRESS])
            ->with('product')
            ->orderBy('id')
            ->limit(5)
            ->get();

        foreach ($orders as $index => $manufacturingOrder) {
            $article = $manufacturingOrder->product;

            $sale = SaleOrderFacade::confirmSaleOrder($this->saleOrder(
                $customers[$index % count($customers)],
                [[$article->reference, (float) $manufacturingOrder->quantity, (float) $article->price]],
                now()->subDays(20 - $index),
            )->refresh());

            OrderAttribute::query()->updateOrCreate(
                ['manufacturing_order_id' => $manufacturingOrder->id],
                ['sale_order_id' => $sale->id],
            );
        }
    }

    /* ---------------------------------------------------- persediaan lain */

    protected function createLotsAndPackages(): void
    {
        $leather = InventoryProduct::query()->create([
            'type'        => ProductType::GOODS,
            'name'        => 'Kulit sapi asli (lembar)',
            'reference'   => 'WEBA-KSA',
            'price'       => 0,
            'cost'        => 65000,
            'uom_id'      => $this->units->id,
            'uom_po_id'   => $this->units->id,
            'category_id' => Category::query()->orderBy('id')->value('id'),
            'company_id'  => $this->company->id,
            'is_storable' => true,
            'tracking'    => ProductTracking::LOT,
        ]);

        foreach ([['KSA-2026-0912', 80], ['KSA-2026-1003', 120]] as [$name, $quantity]) {
            $lot = Lot::query()->create([
                'name'       => $name,
                'product_id' => $leather->id,
                'uom_id'     => $this->units->id,
                'company_id' => $this->company->id,
            ]);

            ProductQuantity::query()->create([
                'product_id'        => $leather->id,
                'location_id'       => $this->warehouse->lot_stock_location_id,
                'lot_id'            => $lot->id,
                'quantity'          => $quantity,
                'reserved_quantity' => 0,
                'incoming_at'       => now()->subDays(20),
                'company_id'        => $this->company->id,
            ]);
        }

        foreach (['PALET-001' => PackageUse::REUSABLE, 'PALET-002' => PackageUse::REUSABLE, 'KARTON-KIRIM-01' => PackageUse::DISPOSABLE] as $name => $use) {
            Package::query()->create([
                'name'        => $name,
                'package_use' => $use,
                'pack_date'   => now()->subDays(3),
                'location_id' => $this->warehouse->lot_stock_location_id,
                'company_id'  => $this->company->id,
            ]);
        }
    }

    protected function createSettingsRecords(): void
    {
        $users = User::query()->pluck('id', 'email');

        foreach ([
            'Tim Produksi'             => ['ppic@weba.local', 'supervisor@weba.local'],
            'Tim Gudang dan Pembelian' => ['gudang@weba.local'],
            'Tim Manajemen'            => ['pimpinan@weba.local', 'admin@weba.local'],
        ] as $name => $emails) {
            $team = Team::query()->create(['name' => $name, 'creator_id' => $this->admin->id]);
            $team->users()->sync(collect($emails)->map(fn (string $email) => $users[$email] ?? null)->filter()->values()->all());
        }

        $plan = ActivityPlan::query()->create([
            'name'       => 'Tindak lanjut penawaran',
            'plugin'     => 'sales',
            'company_id' => $this->company->id,
            'is_active'  => true,
        ]);
        $plan->activityPlanTemplates()->create([
            'activity_type_id' => ActivityType::query()->orderBy('id')->value('id'),
            'summary'          => 'Telepon pelanggan untuk konfirmasi penawaran',
            'delay_count'      => 2,
            'delay_unit'       => 'days',
            'delay_from'       => 'after_plan_date',
            'responsible_type' => 'on_demand',
            'responsible_id'   => $this->admin->id,
        ]);

        $bank = Bank::query()->firstOrCreate(['code' => 'CENAIDJA'], ['name' => 'Bank Central Asia (BCA)', 'country_id' => $this->countryId]);
        $account = BankAccount::query()->create([
            'account_number' => '7350123456',
            'bank_id'        => $bank->id,
            'partner_id'     => $this->company->partner_id,
            'is_active'      => true,
            'can_send_money' => true,
        ]);
        Journal::query()->where('company_id', $this->company->id)->where('type', 'bank')->first()?->update(['bank_account_id' => $account->id]);
    }

    /* ------------------------------------------------------------- bantuan */

    /**
     * Completes every operation that is ready, leg after leg (a delivery or a
     * receipt may have more than one step).
     *
     * @param  callable(): iterable<Operation>  $operations
     */
    protected function completeOperations(callable $operations, bool $onlyReady = false): void
    {
        for ($leg = 0; $leg < 6; $leg++) {
            $next = collect($operations())->first(fn (Operation $operation): bool => $onlyReady
                ? $this->isReady($operation)
                : ! in_array($operation->state, [OperationState::DONE, OperationState::CANCELED], true)
                    && $operation->moves->contains(fn ($move) => ! in_array($move->state, [MoveState::DONE, MoveState::CANCELED, MoveState::DRAFT], true)));

            if (! $next) {
                return;
            }

            Inventory::completeTransfer($next->refresh());
        }
    }

    protected function isReady(Operation $operation): bool
    {
        return ! in_array($operation->state, [OperationState::DONE, OperationState::CANCELED], true)
            && $operation->moves->contains(fn ($move) => in_array($move->state, [MoveState::ASSIGNED, MoveState::PARTIALLY_ASSIGNED], true));
    }

    /**
     * Registers a payment the way the "Register payment" action does, on the
     * bank journal that the accounting plugin installed.
     */
    protected function registerPayment(AccountMove $move, ?float $amount, CarbonInterface $date): void
    {
        $move = $move->refresh();

        $register = new PaymentRegister;
        $register->lines = $move->lines;
        $register->company = $move->company;
        $register->currency = $move->currency;
        $register->currency_id = $move->currency_id;
        $register->payment_type = $move->isInbound(true) ? PaymentType::RECEIVE : PaymentType::SEND;
        $register->computeBatches();
        $register->computeAvailableJournalIds();
        $register->journal_id = Journal::query()->where('company_id', $move->company_id)->where('type', 'bank')->value('id')
            ?? ($register->available_journal_ids[0] ?? null);
        $register->journal = Journal::query()->find($register->journal_id);
        $register->computePaymentMethodLineId();
        $amounts = $register->getTotalAmountsToPay($register->batches);

        $payment = PaymentRegister::query()->create([
            'currency_id'                 => $move->currency_id,
            'journal_id'                  => $register->journal_id,
            'payment_method_line_id'      => $register->payment_method_line_id,
            'company_id'                  => $move->company_id,
            'partner_id'                  => $move->partner_id,
            'payment_type'                => $register->payment_type,
            'payment_date'                => $date->toDateString(),
            'amount'                      => $amount ?? $amounts['amount_by_default'],
            'installments_mode'           => $register->installments_mode ?? 'full',
            'payment_difference_handling' => 'open',
            'communication'               => $move->name,
        ]);
        $payment->lines()->sync($move->paymentTermLines->filter(fn ($line) => ! $line->reconciled)->pluck('id')->all());
        $payment->refresh();
        $payment->computeFromLines();
        $payment->save();

        AccountFacade::createPayments($payment);
    }
}
