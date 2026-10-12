<?php

namespace Weba\ProductionPriority\Navigation;

use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationManager;

/**
 * Filament builds the menu with all its rules (permissions, visibility,
 * badges, order). This class lets it do that and only rearranges the result,
 * so the groups of the daily work panel come first.
 *
 * If anything about the result is unexpected (two groups with the same label,
 * two items with the same address) the menu is returned untouched.
 */
class WorkNavigationManager extends NavigationManager
{
    public const ORIGINAL_ITEMS_START = 'wp-original-items-start';

    protected ?LateOrderBadge $lateOrderBadge = null;

    /**
     * @return array<NavigationGroup>
     */
    public function get(): array
    {
        $groups = array_values(parent::get());

        $this->giveIconsToItemsWithoutOne($groups);

        $curated = app(SidebarDefinition::class)->resolve();

        if ($curated === [] || ! $this->canBeArranged($groups)) {
            $this->moveActiveClusterMenuIntoSidebar($groups, []);

            return $groups;
        }

        $plan = app(SidebarArrangement::class)->arrange(
            array_map(fn (NavigationGroup $group): array => [
                'key'   => (string) $group->getLabel(),
                'items' => collect($group->getItems())->map(fn (NavigationItem $item): string => (string) $item->getUrl())->values()->all(),
            ], $groups),
            array_map(fn (array $group): array => [
                'key'      => $group['key'],
                'absorbs'  => (string) $group['absorbs']->getLabel(),
                'items'    => array_map(fn (array $item): array => ['url' => $item['url'], 'consume' => $item['consume']], $group['items']),
            ], $curated),
        );

        $result = $this->build($plan, $groups, $curated);

        $this->moveActiveClusterMenuIntoSidebar($result, $curated);

        return $result;
    }

    /**
     * Shows the other pages of the cluster the user is in below the cluster item,
     * so the page itself does not need its own box for them. Pages that a
     * shortcut already links to are left out, they are one click away above.
     *
     * @param  array<NavigationGroup>  $groups
     * @param  list<array{key: string, absorbs: \Webkul\Support\Enums\NavigationGroup, items: list<array{id: string, url: string, consume: bool, label: ?string, icon: string, badge: ?string}>}>  $curated
     */
    protected function moveActiveClusterMenuIntoSidebar(array $groups, array $curated): void
    {
        $shortcutUrls = collect($curated)->flatMap(fn (array $group): array => array_column($group['items'], 'url'))->all();
        $subMenu = app(ClusterSubMenu::class);

        foreach ($groups as $group) {
            foreach ($group->getItems() as $item) {
                $url = (string) $item->getUrl();

                if (! $this->isCurrentAddress($url) || ($cluster = $subMenu->clusterAt($url)) === null) {
                    continue;
                }

                $children = $subMenu->flatItems($cluster);

                if ($children === null) {
                    continue;
                }

                $children = array_values(array_filter(
                    $children,
                    fn (NavigationItem $child): bool => ! in_array((string) $child->getUrl(), $shortcutUrls, true),
                ));

                if ($children !== []) {
                    if ($item->getIcon() === null) {
                        $item->icon('heroicon-o-rectangle-stack');
                    }

                    $item->childItems($children);
                }
            }
        }
    }

    /**
     * Must run before any child items are attached: Filament refuses an item that
     * has children and no icon.
     *
     * @param  array<NavigationGroup>  $groups
     */
    protected function giveIconsToItemsWithoutOne(array $groups): void
    {
        $icons = new SidebarIcons;

        foreach ($groups as $group) {
            foreach ($group->getItems() as $item) {
                if ($item->getIcon() === null) {
                    $item->icon($icons->forUrl((string) $item->getUrl()));
                }
            }
        }
    }

    /**
     * @param  array<NavigationGroup>  $groups
     */
    protected function canBeArranged(array $groups): bool
    {
        $labels = array_map(fn (NavigationGroup $group): string => (string) $group->getLabel(), $groups);

        $urls = [];

        foreach ($groups as $group) {
            foreach ($group->getItems() as $item) {
                $urls[] = (string) $item->getUrl();
            }
        }

        return $labels === array_unique($labels) && $urls === array_unique($urls);
    }

    /**
     * @param  list<array{key: string, curated: bool, items: list<array{url: string, curated: bool}>}>  $plan
     * @param  array<NavigationGroup>  $groups
     * @param  list<array{key: string, absorbs: \Webkul\Support\Enums\NavigationGroup, items: list<array{id: string, url: string, consume: bool, label: ?string, icon: string, badge: ?string}>}>  $curated
     * @return array<NavigationGroup>
     */
    protected function build(array $plan, array $groups, array $curated): array
    {
        $groupsByLabel = [];
        $itemsByUrl = [];

        foreach ($groups as $group) {
            $groupsByLabel[(string) $group->getLabel()] = $group;

            foreach ($group->getItems() as $item) {
                $itemsByUrl[(string) $item->getUrl()] = $item;
            }
        }

        $curatedGroups = collect($curated)->keyBy('key');
        $curatedItems = collect($curated)->flatMap(fn (array $group): array => $group['items'])->keyBy('url');

        $result = [];

        foreach ($plan as $entry) {
            $items = [];

            foreach ($entry['items'] as $position => $planned) {
                $items[] = $planned['curated']
                    ? $this->curatedItem($curatedItems[$planned['url']], $itemsByUrl[$planned['url']] ?? null, $position)
                    : $itemsByUrl[$planned['url']];
            }

            $this->quietParentsOfActiveShortcut($items, $entry['items']);
            $this->markWhereOriginalItemsStart($items, $entry['items']);

            if ($entry['curated']) {
                $enum = $curatedGroups[$entry['key']]['absorbs'];

                $result[] = NavigationGroup::make($enum->getLabel())
                    ->icon(($groupsByLabel[$enum->getLabel()] ?? null)?->getIcon() ?? $enum->getIcon())
                    ->items(collect($items));

                continue;
            }

            $result[] = $groupsByLabel[$entry['key']]->items(collect($items));
        }

        return $result;
    }

    /**
     * @param  array{id: string, url: string, consume: bool, label: ?string, icon: string, badge: ?string}  $definition
     */
    protected function curatedItem(array $definition, ?NavigationItem $existing, int $position): NavigationItem
    {
        $item = $existing ?? NavigationItem::make($definition['label'] ?? $definition['id'])
            ->url($definition['url'])
            ->isActiveWhen(fn (): bool => $this->isCurrentAddress($definition['url']));

        if ($definition['label'] !== null) {
            $item->label($definition['label']);
        }

        if ($definition['badge'] === 'late-orders') {
            $item->badge(fn (): ?string => $this->lateOrderBadge()->label(), 'danger');
        }

        return $item
            ->icon($definition['icon'])
            ->sort($position);
    }

    /**
     * A shortcut and the original item that leads to the same part of the system
     * (the cluster it sits in) would both light up on the same page. Only the
     * shortcut stays active.
     *
     * @param  list<NavigationItem>  $items
     * @param  list<array{url: string, curated: bool}>  $planned
     */
    protected function quietParentsOfActiveShortcut(array $items, array $planned): void
    {
        $active = null;

        foreach ($planned as $position => $entry) {
            if ($entry['curated'] && $items[$position]->isActive()) {
                $active = rtrim((string) $items[$position]->getUrl(), '/').'/';

                break;
            }
        }

        if ($active === null) {
            return;
        }

        foreach ($planned as $position => $entry) {
            if ($entry['curated']) {
                continue;
            }

            if (str_starts_with($active, rtrim((string) $items[$position]->getUrl(), '/').'/')) {
                $items[$position]->isActiveWhen(fn (): bool => false);
            }
        }
    }

    /**
     * The shortcuts have icons and the original items do not, so without a hint
     * the original items look like children of the last shortcut. The sidebar
     * view draws a thin line before the item carrying this key.
     *
     * @param  list<NavigationItem>  $items
     * @param  list<array{url: string, curated: bool}>  $planned
     */
    protected function markWhereOriginalItemsStart(array $items, array $planned): void
    {
        $hasShortcut = in_array(true, array_column($planned, 'curated'), true);

        if (! $hasShortcut) {
            return;
        }

        foreach ($planned as $position => $entry) {
            if (! $entry['curated']) {
                $items[$position]->key(self::ORIGINAL_ITEMS_START);

                return;
            }
        }
    }

    protected function lateOrderBadge(): LateOrderBadge
    {
        return $this->lateOrderBadge ??= new LateOrderBadge;
    }

    protected function isCurrentAddress(string $url): bool
    {
        $current = rtrim(request()->url(), '/').'/';

        return str_starts_with($current, rtrim($url, '/').'/');
    }
}
