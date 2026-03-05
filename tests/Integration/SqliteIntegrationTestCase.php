<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration;

use Doctrine\ORM\Configuration;
use Scienta\DoctrineJsonFunctions\Tests\Query\SqliteTestCase;
use Override;

abstract class SqliteIntegrationTestCase extends IntegrationTestCase
{
    /** SQLite runs in-memory — never skips. */
    #[Override]
    protected static function getConnectionUrl(): ?string
    {
        return 'sqlite:///:memory:';
    }

    #[Override]
    protected static function loadDqlFunctions(Configuration $config): void
    {
        SqliteTestCase::loadDqlFunctions($config);
    }
}
