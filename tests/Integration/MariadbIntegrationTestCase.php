<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration;

use Doctrine\ORM\Configuration;
use Scienta\DoctrineJsonFunctions\Tests\Query\MariadbTestCase;
use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;

abstract class MariadbIntegrationTestCase extends IntegrationTestCase
{
    protected static function getConnectionUrl(): ?string
    {
        return $_ENV['MARIADB_URL'] ?? getenv('MARIADB_URL') ?: null;
    }

    protected static function loadDqlFunctions(Configuration $config): void
    {
        // Register shared MySQL+MariaDB functions first, then MariaDB-specific ones.
        // MariaDB\JsonValue overwrites Mysql\JsonValue for the JSON_VALUE key, which is correct.
        MysqlTestCase::loadDqlFunctions($config);
        MariadbTestCase::loadDqlFunctions($config);
    }
}
