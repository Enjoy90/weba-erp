<?php

use Weba\ProductionPriority\Navigation\SidebarIcons;

it('picks the icon from the meaning of the page', function (string $url, string $icon) {
    expect((new SidebarIcons)->forUrl($url))->toBe($icon);
})->with([
    'operations'          => ['http://127.0.0.1/admin/manufacturing/operations', 'heroicon-o-wrench-screwdriver'],
    'products'            => ['/admin/inventory/products', 'heroicon-o-cube'],
    'configurations'      => ['/admin/sale/configurations', 'heroicon-o-adjustments-horizontal'],
    'settings'            => ['/admin/settings', 'heroicon-o-cog-6-tooth'],
    'overview'            => ['/admin/inventory/overview', 'heroicon-o-squares-2x2'],
    'reporting'           => ['/admin/inventory/reporting', 'heroicon-o-chart-bar'],
    'sales orders'        => ['/admin/sale/orders', 'heroicon-o-shopping-bag'],
    'purchase orders'     => ['/admin/purchase/orders', 'heroicon-o-shopping-cart'],
    'roles'               => ['/admin/shield/roles', 'heroicon-o-shield-check'],
    'help'                => ['/admin/help', 'heroicon-o-question-mark-circle'],
    'production priority' => ['/admin/manufacturing/production-priority', 'heroicon-o-chart-bar-square'],
]);

it('gives an icon to a page it does not know, so no item is left without one', function () {
    expect((new SidebarIcons)->forUrl('/admin/something/new-module'))->toBe(SidebarIcons::FALLBACK);
});

it('ignores a trailing slash and a query string', function () {
    expect((new SidebarIcons)->forUrl('/admin/inventory/products/?tab=1'))->toBe('heroicon-o-cube');
});
