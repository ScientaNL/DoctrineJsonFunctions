<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration;

use Doctrine\ORM\Configuration;
use Scienta\DoctrineJsonFunctions\Tests\Query\SqliteTestCase;

abstract class SqliteIntegrationTestCase extends IntegrationTestCase
{
    /** SQLite runs in-memory — never skips. */
    protected static function getConnectionUrl(): ?string
    {
        return 'sqlite:///:memory:';
    }

    protected static function loadDqlFunctions(Configuration $config): void
    {
        SqliteTestCase::loadDqlFunctions($config);
    }
}
