<?php

/**
 * The shared test bootstrap runs migrate:fresh, so tests must never point at
 * the development database.
 */
it('runs against a dedicated test database', function () {
    expect(getenv('DB_DATABASE'))->toBe('weba_erp_test');
});

/**
 * A cached configuration ignores the DB_DATABASE override of phpunit.xml. Feature tests stop
 * on their own (see Tests\TestCase), this test makes the same mistake visible in the unit run.
 */
it('runs without a cached configuration', function () {
    expect(file_exists(dirname(__DIR__, 5).'/bootstrap/cache/config.php'))
        ->toBeFalse('Run "php artisan optimize:clear" before running the tests.');
});
