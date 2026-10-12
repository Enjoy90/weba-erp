<?php

namespace Weba\ProductionPriority\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Webkul\Account\Enums\AmountType;
use Webkul\Account\Enums\TypeTaxUse;
use Webkul\Account\Models\Tax;
use Webkul\Account\Models\TaxGroup;
use Webkul\Account\Models\TaxPartition;
use Webkul\Support\Models\Company;

/**
 * Adds Indonesian VAT (PPN 11%) as a sales tax and a purchase tax for every
 * company. The tax and its repartition lines follow the tax of the same use that
 * the accounting plugin installed, so they post to the same accounts. Running it
 * again changes nothing.
 */
class IndonesianTaxSeeder extends Seeder
{
    public const NAME = 'PPN 11%';

    public const RATE = 11;

    public function run(): void
    {
        if (! Schema::hasTable('accounts_taxes') || ! Schema::hasTable('accounts_tax_partition_lines')) {
            return;
        }

        $indonesiaId = DB::table('countries')->where('code', 'ID')->value('id');

        foreach (Company::query()->get() as $company) {
            $group = TaxGroup::query()->firstOrCreate(
                ['company_id' => $company->id, 'name' => self::NAME],
                ['country_id' => $indonesiaId],
            );

            foreach ([TypeTaxUse::SALE, TypeTaxUse::PURCHASE] as $use) {
                $this->createTax($company, $group, $use, $indonesiaId);
            }
        }
    }

    protected function createTax(Company $company, TaxGroup $group, TypeTaxUse $use, ?int $countryId): void
    {
        $exists = Tax::query()
            ->where('company_id', $company->id)
            ->where('type_tax_use', $use)
            ->where('name', self::NAME)
            ->exists();

        if ($exists) {
            return;
        }

        $template = Tax::query()
            ->where('company_id', $company->id)
            ->where('type_tax_use', $use)
            ->whereHas('invoiceRepartitionLines')
            ->orderBy('id')
            ->first();

        DB::transaction(function () use ($company, $group, $use, $countryId, $template): void {
            $tax = Tax::query()->create([
                'company_id'          => $company->id,
                'tax_group_id'        => $group->id,
                'country_id'          => $countryId,
                'type_tax_use'        => $use,
                'amount_type'         => AmountType::PERCENT,
                'tax_exigibility'     => 'on_invoice',
                'name'                => self::NAME,
                'invoice_label'       => self::NAME,
                'amount'              => self::RATE,
                'is_active'           => true,
                'include_base_amount' => false,
                'is_base_affected'    => false,
            ]);

            foreach (['invoice', 'refund'] as $documentType) {
                foreach (['base', 'tax'] as $sort => $repartitionType) {
                    $templateLine = $template
                        ? TaxPartition::query()
                            ->where('tax_id', $template->id)
                            ->where('document_type', $documentType)
                            ->where('repartition_type', $repartitionType)
                            ->first()
                        : null;

                    (new TaxPartition)->forceFill([
                        'tax_id'             => $tax->id,
                        'company_id'         => $company->id,
                        'document_type'      => $documentType,
                        'repartition_type'   => $repartitionType,
                        'account_id'         => $templateLine?->account_id,
                        'use_in_tax_closing' => $repartitionType === 'tax',
                        'factor'             => 1.0,
                        'factor_percent'     => $repartitionType === 'tax' ? 100.0 : null,
                        'sort'               => $sort + 1,
                    ])->save();
                }
            }
        });
    }
}
