<?php

use Weba\ProductionPriority\Navigation\SidebarArrangement;

function arrangementOriginal(): array
{
    return [
        ['key' => 'Dashboard', 'items' => ['/panel', '/dashboard']],
        ['key' => 'Sales', 'items' => ['/sales/orders', '/sales/products']],
        ['key' => 'Purchase', 'items' => ['/purchase/orders', '/purchase/products']],
        ['key' => 'Manufacturing', 'items' => ['/mfg/operations', '/mfg/products', '/mfg/settings']],
        ['key' => 'Inventory', 'items' => ['/inv/overview', '/inv/operations']],
    ];
}

/**
 * @param  list<array{key: string, curated: bool, items: list<array{url: string, curated: bool}>}>  $result
 * @return list<string>
 */
function arrangementUrls(array $result): array
{
    return collect($result)->flatMap(fn (array $group): array => array_column($group['items'], 'url'))->all();
}

it('leaves the menu as it is when nothing is curated', function () {
    $result = (new SidebarArrangement)->arrange(arrangementOriginal(), []);

    expect(array_column($result, 'key'))->toBe(['Dashboard', 'Sales', 'Purchase', 'Manufacturing', 'Inventory'])
        ->and(arrangementUrls($result))->toBe(['/panel', '/dashboard', '/sales/orders', '/sales/products', '/purchase/orders', '/purchase/products', '/mfg/operations', '/mfg/products', '/mfg/settings', '/inv/overview', '/inv/operations'])
        ->and(collect($result)->pluck('curated')->unique()->all())->toBe([false]);
});

it('puts the curated groups first, in the order given', function () {
    $result = (new SidebarArrangement)->arrange(arrangementOriginal(), [
        ['key' => 'Mfg', 'absorbs' => 'Manufacturing', 'items' => [['url' => '/mfg/orders', 'consume' => false]]],
        ['key' => 'Dash', 'absorbs' => 'Dashboard', 'items' => []],
    ]);

    expect(array_column($result, 'key'))->toBe(['Mfg', 'Dash', 'Sales', 'Purchase', 'Inventory']);
});

it('lists the chosen items first and the rest of the absorbed group after them, in the original order', function () {
    $result = (new SidebarArrangement)->arrange(arrangementOriginal(), [
        ['key' => 'Mfg', 'absorbs' => 'Manufacturing', 'items' => [
            ['url' => '/mfg/orders', 'consume' => false],
            ['url' => '/mfg/work-orders', 'consume' => false],
        ]],
    ]);

    expect($result[0]['items'])->toBe([
        ['url' => '/mfg/orders', 'curated' => true],
        ['url' => '/mfg/work-orders', 'curated' => true],
        ['url' => '/mfg/operations', 'curated' => false],
        ['url' => '/mfg/products', 'curated' => false],
        ['url' => '/mfg/settings', 'curated' => false],
    ]);
});

it('takes an existing item over from another group and removes it from there', function () {
    $result = (new SidebarArrangement)->arrange(arrangementOriginal(), [
        ['key' => 'Inv', 'absorbs' => 'Inventory', 'items' => [['url' => '/purchase/orders', 'consume' => true]]],
    ]);

    $purchase = collect($result)->firstWhere('key', 'Purchase');

    expect(arrangementUrls([$result[0]]))->toBe(['/purchase/orders', '/inv/overview', '/inv/operations'])
        ->and(array_column($purchase['items'], 'url'))->toBe(['/purchase/products']);
});

it('skips a taken-over item that is not in the original menu', function () {
    $result = (new SidebarArrangement)->arrange(arrangementOriginal(), [
        ['key' => 'Inv', 'absorbs' => 'Inventory', 'items' => [['url' => '/hidden/for/this/user', 'consume' => true]]],
    ]);

    expect(arrangementUrls($result))->not->toContain('/hidden/for/this/user');
});

it('drops a group that has nothing left in it', function () {
    $result = (new SidebarArrangement)->arrange(
        [['key' => 'Only', 'items' => ['/only']], ['key' => 'Other', 'items' => ['/other']]],
        [['key' => 'Mine', 'absorbs' => null, 'items' => [['url' => '/only', 'consume' => true]]]],
    );

    expect(array_column($result, 'key'))->toBe(['Mine', 'Other']);
});

it('shows an item that is chosen for two groups only in the first', function () {
    $result = (new SidebarArrangement)->arrange(arrangementOriginal(), [
        ['key' => 'A', 'absorbs' => null, 'items' => [['url' => '/shared', 'consume' => false]]],
        ['key' => 'B', 'absorbs' => null, 'items' => [['url' => '/shared', 'consume' => false], ['url' => '/b-only', 'consume' => false]]],
    ]);

    expect(array_column($result[0]['items'], 'url'))->toBe(['/shared'])
        ->and(array_column($result[1]['items'], 'url'))->toBe(['/b-only']);
});

it('gives a group that is absorbed twice to the first curated group only', function () {
    $result = (new SidebarArrangement)->arrange(arrangementOriginal(), [
        ['key' => 'First', 'absorbs' => 'Sales', 'items' => []],
        ['key' => 'Second', 'absorbs' => 'Sales', 'items' => [['url' => '/second', 'consume' => false]]],
    ]);

    expect(array_column($result[0]['items'], 'url'))->toBe(['/sales/orders', '/sales/products'])
        ->and(array_column($result[1]['items'], 'url'))->toBe(['/second']);
});

it('does not list an item twice when a later group takes it from a group that an earlier one absorbed', function () {
    $result = (new SidebarArrangement)->arrange(arrangementOriginal(), [
        ['key' => 'First', 'absorbs' => 'Inventory', 'items' => []],
        ['key' => 'Second', 'absorbs' => null, 'items' => [['url' => '/inv/overview', 'consume' => true]]],
    ]);

    $urls = arrangementUrls($result);

    expect(array_count_values($urls)['/inv/overview'])->toBe(1)
        ->and(array_column($result[0]['items'], 'url'))->toBe(['/inv/operations'])
        ->and(array_column($result[1]['items'], 'url'))->toBe(['/inv/overview']);
});

it('copes with a curated group that absorbs a group that does not exist', function () {
    $result = (new SidebarArrangement)->arrange(arrangementOriginal(), [
        ['key' => 'Ghost', 'absorbs' => 'Does not exist', 'items' => [['url' => '/ghost', 'consume' => false]]],
    ]);

    expect($result[0]['key'])->toBe('Ghost')
        ->and(array_column($result[0]['items'], 'url'))->toBe(['/ghost']);
});

it('never loses or doubles an item of the original menu, whatever is curated', function (int $seed) {
    mt_srand($seed);

    $original = [];
    $all = [];

    foreach (range(1, mt_rand(1, 8)) as $g) {
        $items = [];

        foreach (range(1, mt_rand(0, 6)) as $i) {
            $items[] = $all[] = "/g{$g}/i{$i}";
        }

        $original[] = ['key' => "G{$g}", 'items' => $items];
    }

    $curated = [];

    foreach (range(1, mt_rand(0, 4)) as $c) {
        $items = [];

        foreach (range(0, mt_rand(0, 5)) as $i) {
            $consume = (bool) mt_rand(0, 1);
            $items[] = [
                'url'     => $consume && $all !== [] ? $all[array_rand($all)] : '/extra/'.mt_rand(1, 6),
                'consume' => $consume,
            ];
        }

        $curated[] = ['key' => "C{$c}", 'absorbs' => mt_rand(0, 1) ? 'G'.mt_rand(1, 9) : null, 'items' => $items];
    }

    $urls = arrangementUrls((new SidebarArrangement)->arrange($original, $curated));

    expect(array_diff($all, $urls))->toBe([])
        ->and($urls)->toBe(array_values(array_unique($urls)));
})->with(range(1, 200));
