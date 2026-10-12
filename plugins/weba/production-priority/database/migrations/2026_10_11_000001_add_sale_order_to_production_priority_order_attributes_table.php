<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Confirming a sales order does not create a manufacturing order in this ERP, so
 * the link between the two is kept here. The column has no foreign key because the
 * sales plugin is optional and its table may not exist.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('production_priority_order_attributes', function (Blueprint $table) {
            $table->unsignedBigInteger('sale_order_id')
                ->nullable()
                ->index('pp_order_attributes_sale_order_index')
                ->after('order_value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('production_priority_order_attributes', function (Blueprint $table) {
            $table->dropIndex('pp_order_attributes_sale_order_index');
            $table->dropColumn('sale_order_id');
        });
    }
};
