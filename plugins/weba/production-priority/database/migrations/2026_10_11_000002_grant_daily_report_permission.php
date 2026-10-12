<?php

use Illuminate\Database\Migrations\Migration;
use Webkul\Security\Models\Permission;

/**
 * Shield only hands a new page permission to roles when a plugin is installed,
 * so an installation that already runs would answer 403 on the new page. Every
 * role that may open the production dashboard may open the daily report too.
 */
return new class extends Migration
{
    private const DASHBOARD_PERMISSION = 'page_production_priority_production_dashboard';

    private const DAILY_REPORT_PERMISSION = 'page_production_priority_daily_report';

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
            $dailyReportPermission = Permission::query()->firstOrCreate([
                'name'       => self::DAILY_REPORT_PERMISSION,
                'guard_name' => $dashboardPermission->guard_name,
            ]);

            foreach ($dashboardPermission->roles as $role) {
                $role->givePermissionTo($dailyReportPermission);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::query()->where('name', self::DAILY_REPORT_PERMISSION)->delete();
    }
};
