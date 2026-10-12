<?php

namespace Weba\ProductionPriority\Database\Seeders;

use Illuminate\Database\Seeder;
use Weba\ProductionPriority\Support\Abilities;
use Weba\ProductionPriority\Support\ProductionRoles;
use Webkul\Security\Models\Permission;
use Webkul\Security\Models\Role;

/**
 * Creates the abilities that Shield does not generate, gives them to the Admin
 * role, and creates the production roles. A role that exists already is left as
 * it is: whoever edited it later made a choice that must stay.
 */
class ProductionRoleSeeder extends Seeder
{
    private const GUARD = 'web';

    public function run(): void
    {
        foreach (Abilities::all() as $ability) {
            $this->permission($ability);
        }

        $this->giveAdminTheAbilities();

        foreach (ProductionRoles::definitions() as $name => $permissions) {
            $role = Role::query()->firstOrCreate(['name' => $name, 'guard_name' => self::GUARD]);

            if (! $role->wasRecentlyCreated) {
                continue;
            }

            $role->givePermissionTo(array_map(fn (string $permission): Permission => $this->permission($permission), $permissions));
        }
    }

    protected function giveAdminTheAbilities(): void
    {
        $admin = Role::query()->where('name', config('filament-shield.panel_user.name'))->where('guard_name', self::GUARD)->first();

        $admin?->givePermissionTo(array_map(fn (string $ability): Permission => $this->permission($ability), Abilities::all()));
    }

    protected function permission(string $name): Permission
    {
        return Permission::query()->firstOrCreate(['name' => $name, 'guard_name' => self::GUARD]);
    }
}
