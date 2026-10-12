<?php

namespace Weba\ProductionPriority\Navigation;

/**
 * Puts a few chosen groups first in the sidebar and fills them with chosen
 * items, without ever losing a menu item: every item that exists in the
 * original menu is in the result exactly once.
 *
 * The class knows nothing about Filament, it only moves identifiers (URLs)
 * around, so its rules can be tested with plain arrays.
 */
class SidebarArrangement
{
    /**
     * A curated item with consume set to true only counts when its URL is an
     * item of the original menu, and takes that item over. Without consume it
     * is an extra shortcut that is added.
     *
     * @param  list<array{key: string, items: list<string>}>  $original  the menu as it is now, in display order
     * @param  list<array{key: string, absorbs: ?string, items: list<array{url: string, consume: bool}>}>  $curated  the groups to put first
     * @return list<array{key: string, curated: bool, items: list<array{url: string, curated: bool}>}>
     */
    public function arrange(array $original, array $curated): array
    {
        $originalUrls = [];

        foreach ($original as $group) {
            foreach ($group['items'] as $url) {
                $originalUrls[$url] = true;
            }
        }

        $placed = [];
        $chosen = [];

        foreach ($curated as $index => $group) {
            $chosen[$index] = [];

            foreach ($group['items'] as $item) {
                if (isset($placed[$item['url']])) {
                    continue;
                }

                if ($item['consume'] && ! isset($originalUrls[$item['url']])) {
                    continue;
                }

                $placed[$item['url']] = true;
                $chosen[$index][] = ['url' => $item['url'], 'curated' => true];
            }
        }

        $result = [];
        $absorbed = [];

        foreach ($curated as $index => $group) {
            $items = $chosen[$index];
            $absorbs = $group['absorbs'];

            if ($absorbs !== null && ! isset($absorbed[$absorbs])) {
                $absorbed[$absorbs] = true;
                $items = [...$items, ...$this->leftovers($original, $absorbs, $placed)];
            }

            if ($items !== []) {
                $result[] = ['key' => $group['key'], 'curated' => true, 'items' => $items];
            }
        }

        foreach ($original as $group) {
            if (isset($absorbed[$group['key']])) {
                continue;
            }

            $items = $this->leftoverItems($group['items'], $placed);

            if ($items !== []) {
                $result[] = ['key' => $group['key'], 'curated' => false, 'items' => $items];
            }
        }

        return $result;
    }

    /**
     * @param  list<array{key: string, items: list<string>}>  $original
     * @param  array<string, true>  $placed
     * @return list<array{url: string, curated: bool}>
     */
    protected function leftovers(array $original, string $groupKey, array $placed): array
    {
        foreach ($original as $group) {
            if ($group['key'] === $groupKey) {
                return $this->leftoverItems($group['items'], $placed);
            }
        }

        return [];
    }

    /**
     * @param  list<string>  $urls
     * @param  array<string, true>  $placed
     * @return list<array{url: string, curated: bool}>
     */
    protected function leftoverItems(array $urls, array $placed): array
    {
        $items = [];

        foreach ($urls as $url) {
            if (! isset($placed[$url])) {
                $items[] = ['url' => $url, 'curated' => false];
            }
        }

        return $items;
    }
}
