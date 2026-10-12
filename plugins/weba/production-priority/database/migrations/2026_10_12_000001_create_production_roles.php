<?php

use Illuminate\Database\Migrations\Migration;
use Weba\ProductionPriority\Database\Seeders\ProductionRoleSeeder;
use Weba\ProductionPriority\Support\Abilities;
use Weba\ProductionPriority\Support\ProductionRoles;
use Webkul\Security\Models\Permission;
use Webkul\Security\Models\Role;

/**
 * An installation that already runs gets the new abilities and the production
 * roles here, because the seeder of the plugin only runs when it is installed.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        (new ProductionRoleSeeder)->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Role::query()->whereIn('name', array_keys(ProductionRoles::definitions()))->get()->each->delete();

        Permission::query()->whereIn('name', Abilities::all())->delete();
    }
};
