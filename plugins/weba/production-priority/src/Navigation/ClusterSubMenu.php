<?php

namespace Weba\ProductionPriority\Navigation;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationManager;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Illuminate\Support\Arr;

/**
 * Filament shows the other pages of a cluster in a box next to the page. This
 * class decides which of those lists move into the sidebar instead, and hands
 * the sidebar its items.
 *
 * Only a flat list moves. A cluster whose list has headings (the settings
 * cluster has four items called "Manage Products" under different headings)
 * stays in the page, because without the headings the items cannot be told apart.
 * Lists of a single record (view, edit, bills of one quotation) always stay.
 */
class ClusterSubMenu
{
    /**
     * @return list<NavigationItem>|null the items, or null when the cluster list has headings
     */
    public function flatItems(string $clusterClass): ?array
    {
        $items = [];
        $headings = [];

        foreach (app($clusterClass)->getSubNavigation() as $entry) {
            if ($entry instanceof NavigationGroup) {
                return null;
            }

            $headings[] = (string) ($entry->getGroup() instanceof \UnitEnum ? $entry->getGroup()->name : $entry->getGroup());
            $items[] = $entry;
        }

        return count(array_unique($headings)) <= 1 ? $items : null;
    }

    /**
     * The cluster whose address is exactly this one, if the panel has such a cluster.
     *
     * @return class-string|null
     */
    public function clusterAt(string $url): ?string
    {
        $panel = Filament::getCurrentPanel();

        foreach ($panel?->getClusters() ?? [] as $cluster) {
            if (rtrim($cluster::getUrl(), '/') === rtrim($url, '/')) {
                return $cluster;
            }
        }

        return null;
    }

    /**
     * Whether the cluster list of this page is shown in the sidebar, so the page
     * itself can leave it out.
     */
    public function movesToSidebar(object $page): bool
    {
        if (Filament::getCurrentPanel()?->getId() !== 'admin') {
            return false;
        }

        if (! app(NavigationManager::class) instanceof WorkNavigationManager) {
            return false;
        }

        if (in_array(InteractsWithRecord::class, Arr::wrap(class_uses_recursive($page)), true)) {
            return false;
        }

        $cluster = method_exists($page, 'getCluster') ? $page::getCluster() : null;

        if ($cluster === null || ! $cluster::shouldRegisterSubNavigation()) {
            return false;
        }

        return $this->flatItems($cluster) !== null;
    }
}
