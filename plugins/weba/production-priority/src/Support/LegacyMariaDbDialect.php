<?php

namespace Weba\ProductionPriority\Support;

use Illuminate\Database\ConnectionInterface;
use PDO;
use Throwable;
use Webkul\Support\Database\Dialects\MySqlDialect;

/**
 * MariaDB before 10.5 (the one XAMPP ships) has no JSON_ARRAYAGG, which the
 * accounting plugin uses when it reconciles a payment with an invoice. The
 * replacement builds the same JSON text from GROUP_CONCAT and JSON_QUOTE.
 */
class LegacyMariaDbDialect extends MySqlDialect
{
    public function jsonArrayAgg(string $column): string
    {
        return "CONCAT('[', COALESCE(GROUP_CONCAT(JSON_QUOTE({$column})), ''), ']')";
    }

    public static function isNeededFor(ConnectionInterface $connection): bool
    {
        if (! in_array($connection->getDriverName(), ['mysql', 'mariadb'], true)) {
            return false;
        }

        try {
            $version = (string) $connection->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION);
        } catch (Throwable) {
            return false;
        }

        return preg_match('/(\d+\.\d+\.\d+)-MariaDB/i', $version, $matches) === 1
            && version_compare($matches[1], '10.5.0', '<');
    }
}
