<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use RuntimeException;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        if (! $this->app) {
            $this->refreshApplication();
        }

        $this->guardTestDatabase();

        \TestBootstrapHelper::ensureERPInstalled();

        parent::setUp();
    }

    /**
     * TestBootstrapHelper runs migrate:fresh on the first test, which wipes the connected
     * database. A cached configuration (php artisan optimize) ignores the DB_DATABASE that
     * phpunit.xml forces, so the connection would silently point at the development database.
     *
     * @throws RuntimeException when the connection is not the dedicated test database
     */
    protected function guardTestDatabase(): void
    {
        $connection = config('database.default');
        $database = (string) config("database.connections.{$connection}.database");
        $expected = (string) getenv('DB_DATABASE');

        if ($database === $expected && str_contains($database, '_test')) {
            return;
        }

        throw new RuntimeException(sprintf(
            'Refusing to run: the tests would use database [%s], but they must use the test database '
            .'that phpunit.xml forces [%s], and its name must contain "_test". '
            .'The configuration is probably cached, run "php artisan optimize:clear" and try again.',
            $database,
            $expected,
        ));
    }
}
