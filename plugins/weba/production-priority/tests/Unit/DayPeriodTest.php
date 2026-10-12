<?php

use Weba\ProductionPriority\Enums\DayPeriod;

it('maps every hour of the day to a period', function (int $hour, DayPeriod $expected) {
    expect(DayPeriod::fromHour($hour))->toBe($expected);
})->with([
    'before dawn'   => [3, DayPeriod::Night],
    'dawn'          => [4, DayPeriod::Morning],
    'late morning'  => [10, DayPeriod::Morning],
    'noon'          => [11, DayPeriod::Afternoon],
    'mid afternoon' => [14, DayPeriod::Afternoon],
    'three o clock' => [15, DayPeriod::Evening],
    'dusk'          => [17, DayPeriod::Evening],
    'six o clock'   => [18, DayPeriod::Night],
    'midnight'      => [0, DayPeriod::Night],
    'last hour'     => [23, DayPeriod::Night],
]);

it('covers all 24 hours without a gap', function () {
    foreach (range(0, 23) as $hour) {
        expect(DayPeriod::fromHour($hour))->toBeInstanceOf(DayPeriod::class);
    }
});
