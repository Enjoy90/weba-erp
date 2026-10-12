<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Weba\ProductionPriority\Database\Seeders\IndonesianTaxSeeder;
use Webkul\Account\Models\Tax;

/**
 * An installation that already runs gets PPN 11% here, because the seeder of the
 * plugin only runs when it is installed.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        (new IndonesianTaxSeeder)->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! class_exists(Tax::class) || ! Schema::hasTable('accounts_taxes')) {
            return;
        }

        Tax::query()->where('name', IndonesianTaxSeeder::NAME)->each(function (Tax $tax): void {
            $tax->invoiceRepartitionLines()->delete();
            $tax->refundRepartitionLines()->delete();
            $tax->delete();
        });
    }
};
