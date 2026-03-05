<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration;

use Doctrine\ORM\Configuration;
use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;

abstract class MysqlIntegrationTestCase extends IntegrationTestCase
{
    protected static function getConnectionUrl(): ?string
    {
        return $_ENV['MYSQL_URL'] ?? getenv('MYSQL_URL') ?: null;
    }

    protected static function loadDqlFunctions(Configuration $config): void
    {
        MysqlTestCase::loadDqlFunctions($config);
    }
}
