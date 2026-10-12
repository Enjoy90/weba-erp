<?php

use Illuminate\Database\Migrations\Migration;
use Webkul\Security\Models\Permission;

/**
 * Shield only hands a new page permission to roles when a plugin is installed,
 * so an installation that already runs would answer 403 on the new page. Every
 * role that may open the production dashboard may open the work panel too.
 */
return new class extends Migration
{
    private const DASHBOARD_PERMISSION = 'page_production_priority_production_dashboard';

    private const WORK_PANEL_PERMISSION = 'page_production_priority_work_panel';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $dashboardPermissions = Permission::query()
            ->where('name', self::DASHBOARD_PERMISSION)
            ->with('roles')
            ->get();

        foreach ($dashboardPermissions as $dashboardPermission) {
            $workPanelPermission = Permission::query()->firstOrCreate([
                'name'       => self::WORK_PANEL_PERMISSION,
                'guard_name' => $dashboardPermission->guard_name,
            ]);

            foreach ($dashboardPermission->roles as $role) {
                $role->givePermissionTo($workPanelPermission);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::query()->where('name', self::WORK_PANEL_PERMISSION)->delete();
    }
};
