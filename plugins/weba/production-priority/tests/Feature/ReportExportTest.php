<?php

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Weba\ProductionPriority\Database\Seeders\CriterionSeeder;
use Weba\ProductionPriority\Exports\ReportTableExport;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\EvaluationResource\Pages\ViewEvaluation;
use Weba\ProductionPriority\Filament\Clusters\ProductionPriority\Resources\OrderMonitoringResource\Pages\ListOrderMonitoring;
use Weba\ProductionPriority\Filament\Pages\DailyProductionReport;
use Weba\ProductionPriority\Models\OrderAttribute;
use Weba\ProductionPriority\Services\EvaluationService;
use Weba\ProductionPriority\Services\Reports\DailyProductionReportBuilder;
use Weba\ProductionPriority\Services\Reports\OrderMonitoringReportBuilder;
use Weba\ProductionPriority\Services\Reports\PriorityRankingReportBuilder;
use Weba\ProductionPriority\Support\Letterhead;
use Weba\ProductionPriority\Support\ReportTable;
use Webkul\Manufacturing\Enums\WorkOrderState;
use Webkul\Manufacturing\Models\Order;
use Webkul\Manufacturing\Models\WorkCenterProductivityLog;
use Webkul\Manufacturing\Models\WorkOrder;
use Webkul\PluginManager\Models\Plugin;
use Webkul\PluginManager\Package;
use Webkul\Support\Models\Company;

require_once __DIR__.'/../../../../webkul/support/tests/Helpers/TestBootstrapHelper.php';
require_once __DIR__.'/../../../../webkul/inventories/tests/Helpers/InventoryHelper.php';
require_once __DIR__.'/../../../../webkul/manufacturing/tests/Helpers/ManufacturingHelper.php';

/*
 * Excel export of the SAW ranking, the order monitoring and the daily production
 * report (PRD C8, todo 8.2). The report rows are built apart from the file, so
 * both are checked: what goes in the rows, and what a spreadsheet makes of them.
 */

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

    ManufacturingHelper::actingAsAdmin();

    Carbon::setTestNow(Carbon::parse('2026-10-09 12:00:00'));

    $this->company = ManufacturingHelper::company();
    $this->warehouse = InventoryHelper::warehouse();
    $this->finished = ManufacturingHelper::product();
    $this->component = ManufacturingHelper::product();
    $this->workCenter = ManufacturingHelper::workCenter();
});

afterEach(function () {
    Carbon::setTestNow();
});

function exportOrder(object $test, ?string $deadline = '2026-10-12 12:00:00'): Order
{
    $bom = ManufacturingHelper::bom($test->finished, [[$test->component, 2]]);
    $order = ManufacturingHelper::confirm(ManufacturingHelper::order($test->warehouse, $test->finished, $bom, 5));

    DB::table('manufacturing_orders')->where('id', $order->id)->update(['deadline_at' => $deadline]);

    return $order->refresh();
}

/**
 * The sheet that a spreadsheet program would show for the report.
 *
 * @return list<list<mixed>>
 */
function exportSheet(ReportTable $report): array
{
    $path = tempnam(sys_get_temp_dir(), 'report').'.xlsx';
    file_put_contents($path, Excel::raw(new ReportTableExport($report), ExcelFormat::XLSX));

    $sheet = IOFactory::load($path)->getActiveSheet();
    unlink($path);

    return $sheet->toArray(null, true, false, false);
}

/**
 * Lets a test see which report table a page builds, while the real builder
 * still does the work.
 */
function exportSpy(string $builder): object
{
    $real = app($builder);
    $spy = new stdClass;
    $spy->arguments = [];

    $mock = Mockery::mock($builder)->makePartial();
    $mock->shouldReceive('build')->andReturnUsing(function (...$arguments) use ($real, $spy): ReportTable {
        $spy->arguments = $arguments;

        return $real->build(...$arguments);
    });

    app()->instance($builder, $mock);

    return $spy;
}

describe('report file', function () {
    it('puts the title and details above a bold heading row and keeps numbers as numbers', function () {
        $report = new ReportTable('Test report', ['Name', 'Amount'], [['A', 1500.5], ['B', null]], ['Line one', 'Line two']);

        $sheet = exportSheet($report);

        expect($sheet[0][0])->toBe('Test report')
            ->and($sheet[1][0])->toBe('Line one')
            ->and($sheet[2][0])->toBe('Line two')
            ->and($sheet[4])->toBe(['Name', 'Amount'])
            ->and($sheet[5])->toBe(['A', 1500.5])
            ->and($sheet[6])->toBe(['B', null]);
    });

    it('names the file after the report and the day', function () {
        expect((new ReportTable('SAW priority ranking', [], []))->fileName('xlsx'))->toBe('saw-priority-ranking-2026-10-09.xlsx');
    });
});

describe('priority ranking', function () {
    it('has a row per ranked order with the raw value of every criterion', function () {
        $order = exportOrder($this);
        $evaluation = app(EvaluationService::class)->run($this->company->id);

        $report = app(PriorityRankingReportBuilder::class)->build($evaluation);

        expect($report->headings)->toHaveCount(5 + count($evaluation->criteria_snapshot))
            ->and($report->headings[5])->toStartWith('C1')
            ->and($report->rows)->toHaveCount(1)
            ->and($report->rows[0][0])->toBe(1)
            ->and($report->rows[0][1])->toBe($order->name)
            ->and($report->rows[0][3])->toBe('2026-10-12 12:00')
            ->and($report->rows[0][5])->toBe(3.0)
            ->and($report->details[0])->toContain($evaluation->name);
    });

    it('is downloaded from the evaluation page', function () {
        exportOrder($this);
        $evaluation = app(EvaluationService::class)->run($this->company->id);

        Livewire::test(ViewEvaluation::class, ['record' => $evaluation->getKey()])
            ->callAction('exportExcel')
            ->assertFileDownloaded('saw-priority-ranking-2026-10-09.xlsx');
    });
});

describe('order monitoring', function () {
    it('has the progress, urgency and value of each order', function () {
        $order = exportOrder($this);
        OrderAttribute::factory()->urgency(4)->orderValue(250000000)->create(['manufacturing_order_id' => $order->id]);

        $report = app(OrderMonitoringReportBuilder::class)->build(new Collection([$order->refresh()]));
        $row = $report->rows[0];

        expect($row[0])->toBe($order->name)
            ->and($row[4])->toBe('2026-10-12 12:00')
            ->and($row[8])->toBe(4)
            ->and($row[9])->toBe(250000000.0)
            ->and($row[10])->toBe('Entered by hand');
    });

    it('is downloaded with only the rows that the filters leave', function () {
        $late = exportOrder($this, '2026-10-01 12:00:00');
        $onTime = exportOrder($this, '2026-10-20 12:00:00');
        $spy = exportSpy(OrderMonitoringReportBuilder::class);

        Livewire::test(ListOrderMonitoring::class)
            ->filterTable('late')
            ->callAction('exportExcel')
            ->assertFileDownloaded('order-monitoring-2026-10-09.xlsx');

        expect($spy->arguments[0]->pluck('id')->all())->toBe([$late->id])
            ->and($spy->arguments[0]->pluck('id')->all())->not->toContain($onTime->id);
    });
});

describe('daily production report', function () {
    it('has planned and achieved figures of each work order', function () {
        $workOrder = ManufacturingHelper::workOrder(exportOrder($this), $this->workCenter, null, ['state' => WorkOrderState::DONE, 'name' => 'Cutting']);
        DB::table('manufacturing_work_orders')->where('id', $workOrder->id)->update([
            'finished_at'       => '2026-10-09 16:00:00',
            'expected_duration' => 60,
            'duration'          => 40,
            'quantity_produced' => 5,
        ]);

        $rows = WorkOrder::query()->withSum('productivityLogs as minutes_in_period', 'duration')->get();

        $report = app(DailyProductionReportBuilder::class)->build($rows, '2026-10-09', '2026-10-09');

        expect($report->rows[0][2])->toBe('Cutting')
            ->and($report->rows[0][5])->toBe(5.0)
            ->and($report->rows[0][6])->toBe(5.0)
            ->and($report->rows[0][7])->toBe(60.0)
            ->and($report->rows[0][8])->toBe(40.0)
            ->and($report->rows[0][9])->toBe(150.0)
            ->and($report->details[0])->toBe('Period: 2026-10-09 to 2026-10-09');
    });

    it('is downloaded for the period and work center that were chosen', function () {
        $inPeriod = ManufacturingHelper::workOrder(exportOrder($this), $this->workCenter, null, ['state' => WorkOrderState::PROGRESS]);
        $outside = ManufacturingHelper::workOrder(exportOrder($this), $this->workCenter, null, ['state' => WorkOrderState::PROGRESS]);

        foreach ([[$inPeriod, '2026-10-09'], [$outside, '2026-10-02']] as [$workOrder, $day]) {
            WorkCenterProductivityLog::factory()->productive(30)->create([
                'work_order_id'  => $workOrder->id,
                'work_center_id' => $this->workCenter->id,
                'company_id'     => $this->company->id,
                'started_at'     => Carbon::parse($day.' 09:00:00'),
                'finished_at'    => Carbon::parse($day.' 09:30:00'),
            ]);
        }

        $spy = exportSpy(DailyProductionReportBuilder::class);

        Livewire::test(DailyProductionReport::class)
            ->callAction('exportExcel')
            ->assertFileDownloaded('daily-production-report-2026-10-09.xlsx');

        expect($spy->arguments[0]->pluck('id')->all())->toBe([$inPeriod->id])
            ->and($spy->arguments[1])->toBe('2026-10-09')
            ->and($spy->arguments[2])->toBe('2026-10-09')
            ->and((float) $spy->arguments[0]->first()->minutes_in_period)->toBe(30.0);
    });
});

describe('pdf', function () {
    it('shows the company letterhead above the title, details and rows', function () {
        $company = Company::query()->find(current_company_id());
        $company->update(['name' => 'PT. Weba International', 'street1' => 'Jl. Industri No. 1', 'city' => 'Bandung', 'zip' => '40111', 'phone' => '022-555', 'email' => 'info@weba.test']);

        $report = new ReportTable('Test report', ['Name', 'Amount'], [['Alpha', 1500.5], ['Beta', 3], ['Gamma', null]], ['Period: today']);

        $html = view('production-priority::pdf.report', [
            'report'     => $report,
            'letterhead' => Letterhead::current(),
            'printedBy'  => 'Rina',
            'printedAt'  => '2026-10-09 12:00',
        ])->render();

        expect($html)->toContain('PT. Weba International', 'Jl. Industri No. 1', '40111 Bandung', 'Tel. 022-555', 'info@weba.test')
            ->toContain('Test report', 'Period: today', '<th>Name</th>', 'Alpha', '1,500.5', 'Beta')
            ->toContain('Printed by Rina on 2026-10-09 12:00');
    });

    it('says so when the report has no rows', function () {
        $html = view('production-priority::pdf.report', [
            'report'     => new ReportTable('Empty report', ['Name'], []),
            'letterhead' => Letterhead::current(),
            'printedBy'  => 'Rina',
            'printedAt'  => '2026-10-09 12:00',
        ])->render();

        expect($html)->toContain('No rows in this report');
    });

    it('is turned into a real PDF document', function () {
        $output = Pdf::loadView('production-priority::pdf.report', [
            'report'     => new ReportTable('Test report', ['Name', 'Amount'], [['Alpha', 1500.5]]),
            'letterhead' => Letterhead::current(),
            'printedBy'  => 'Rina',
            'printedAt'  => '2026-10-09 12:00',
        ])->setPaper('a4', 'landscape')->output();

        expect($output)->toStartWith('%PDF');
    });

    it('falls back to the application name without a company', function () {
        expect(Letterhead::forCompany(null)->name)->toBe(config('app.name'));
    });

    it('is downloaded from the evaluation page, the monitoring list and the daily report', function () {
        exportOrder($this);
        $evaluation = app(EvaluationService::class)->run($this->company->id);

        Livewire::test(ViewEvaluation::class, ['record' => $evaluation->getKey()])
            ->callAction('exportPdf')
            ->assertFileDownloaded('saw-priority-ranking-2026-10-09.pdf');

        Livewire::test(ListOrderMonitoring::class)
            ->callAction('exportPdf')
            ->assertFileDownloaded('order-monitoring-2026-10-09.pdf');

        Livewire::test(DailyProductionReport::class)
            ->callAction('exportPdf')
            ->assertFileDownloaded('daily-production-report-2026-10-09.pdf');
    });
});
