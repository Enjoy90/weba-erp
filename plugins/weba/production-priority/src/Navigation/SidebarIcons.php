<?php

namespace Weba\ProductionPriority\Navigation;

/**
 * Icons for the menu items that the modules deliver without one. The icon follows
 * the meaning of the page, taken from the last part of its address, so it works
 * in every language and for modules added later. An unknown page still gets an
 * icon, so no item of the sidebar is left without one.
 */
class SidebarIcons
{
    public const FALLBACK = 'heroicon-o-squares-2x2';

    /**
     * @var array<string, string>
     */
    protected const BY_PAGE = [
        'overview'            => 'heroicon-o-squares-2x2',
        'operations'          => 'heroicon-o-wrench-screwdriver',
        'products'            => 'heroicon-o-cube',
        'reporting'           => 'heroicon-o-chart-bar',
        'configurations'      => 'heroicon-o-adjustments-horizontal',
        'settings'            => 'heroicon-o-cog-6-tooth',
        'orders'              => 'heroicon-o-shopping-bag',
        'invoice'             => 'heroicon-o-document-text',
        'customers'           => 'heroicon-o-users',
        'vendors'             => 'heroicon-o-building-storefront',
        'plugins'             => 'heroicon-o-puzzle-piece',
        'roles'               => 'heroicon-o-shield-check',
        'companies'           => 'heroicon-o-building-office',
        'teams'               => 'heroicon-o-user-group',
        'users'               => 'heroicon-o-users',
        'fields'              => 'heroicon-o-rectangle-group',
        'sequences'           => 'heroicon-o-hashtag',
        'help'                => 'heroicon-o-question-mark-circle',
        'production-priority' => 'heroicon-o-chart-bar-square',
    ];

    public function forUrl(string $url): string
    {
        $path = (string) parse_url($url, PHP_URL_PATH);
        $segments = array_values(array_filter(explode('/', $path)));
        $page = (string) end($segments);

        if ($page === 'orders' && in_array('purchase', $segments, true)) {
            return 'heroicon-o-shopping-cart';
        }

        return self::BY_PAGE[$page] ?? self::FALLBACK;
    }
}
