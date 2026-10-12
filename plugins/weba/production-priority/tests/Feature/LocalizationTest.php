<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;
use Weba\ProductionPriority\Database\Seeders\IndonesianTaxSeeder;
use Webkul\Account\Enums\TypeTaxUse;
use Webkul\Account\Models\Tax;
use Webkul\Account\Models\TaxPartition;
use Webkul\PluginManager\Models\Plugin;
use Webkul\PluginManager\Package;

require_once __DIR__.'/../../../../webkul/support/tests/Helpers/TestBootstrapHelper.php';

/*
 * Phase 1 (todo 1.1 to 1.6, PRD D1 and D2): Indonesian as a language of the
 * application, Rupiah formatting, and PPN 11% as a tax.
 */

beforeEach(function () {
    TestBootstrapHelper::ensurePluginInstalled('accounts');
    TestBootstrapHelper::ensurePluginInstalled('production-priority');

    Package::$plugins = Plugin::all()->keyBy('name');
});

afterEach(function () {
    app()->setLocale(config('app.fallback_locale'));
});

describe('language', function () {
    it('offers Indonesian as a language of the application', function () {
        expect(config('app.supported_locales'))->toHaveKey('id')
            ->and(config('app.supported_locales.id.native'))->toBe('Bahasa Indonesia')
            ->and(file_exists(public_path('flags/id.svg')))->toBeTrue();
    });

    it('translates the menu groups, the validation messages and the plugins', function () {
        app()->setLocale('id');

        expect(__('admin.navigation.manufacturing'))->toBe('Manufaktur')
            ->and(__('validation.required', ['attribute' => 'nama']))->toBe('Kolom nama wajib diisi.')
            ->and(__('auth.failed'))->toBe('Email atau kata sandi tidak sesuai dengan data kami.')
            ->and(__('production-priority::filament/daily-report.navigation.title'))->toBe('Laporan produksi harian');
    });

    it('falls back to English for a text that has no Indonesian translation', function () {
        app()->setLocale('id');

        app('translator')->addLines(['test.only-english' => 'Only in English'], 'en');

        expect(__('test.only-english'))->toBe('Only in English');
    });

    it('writes Rupiah with Indonesian separators', function () {
        expect(Number::currency(1234567.5, 'IDR', 'id'))->toBe("Rp\u{00A0}1.234.567,50")
            ->and(Number::format(1234567, locale: 'id'))->toBe('1.234.567');
    });
});

describe('PPN 11%', function () {
    beforeEach(function () {
        DB::table('accounts_tax_partition_lines')->whereIn('tax_id', Tax::query()->where('name', IndonesianTaxSeeder::NAME)->pluck('id'))->delete();
        Tax::query()->where('name', IndonesianTaxSeeder::NAME)->delete();
    });

    it('adds a sales and a purchase tax of 11 percent with valid repartition lines', function () {
        (new IndonesianTaxSeeder)->run();

        foreach ([TypeTaxUse::SALE, TypeTaxUse::PURCHASE] as $use) {
            $tax = Tax::query()->where('name', IndonesianTaxSeeder::NAME)->where('type_tax_use', $use)->firstOrFail();

            expect((float) $tax->amount)->toBe(11.0)
                ->and((bool) $tax->include_base_amount)->toBeFalse()
                ->and($tax->invoiceRepartitionLines()->count())->toBe(2)
                ->and($tax->refundRepartitionLines()->count())->toBe(2);

            TaxPartition::validateRepartitionLines($tax->id);
        }
    });

    it('posts the tax to the same account as the tax of the same use that was installed', function () {
        (new IndonesianTaxSeeder)->run();

        $ppn = Tax::query()->where('name', IndonesianTaxSeeder::NAME)->where('type_tax_use', TypeTaxUse::SALE)->firstOrFail();
        $installed = Tax::query()->where('name', '!=', IndonesianTaxSeeder::NAME)->where('type_tax_use', TypeTaxUse::SALE)->whereHas('invoiceRepartitionLines')->orderBy('id')->first();

        $accountOf = fn (Tax $tax) => $tax->invoiceRepartitionLines()->where('repartition_type', 'tax')->value('account_id');

        expect($accountOf($ppn))->toBe($installed ? $accountOf($installed) : null);
    });

    it('changes nothing when it runs again', function () {
        (new IndonesianTaxSeeder)->run();
        (new IndonesianTaxSeeder)->run();

        expect(Tax::query()->where('name', IndonesianTaxSeeder::NAME)->count())->toBe(2);
    });
});
