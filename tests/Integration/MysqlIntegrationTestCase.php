<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration;

use Doctrine\ORM\Configuration;
use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;
use Override;

abstract class MysqlIntegrationTestCase extends IntegrationTestCase
{
    #[Override]
    protected static function getConnectionUrl(): ?string
    {
        return ($_ENV['MYSQL_URL'] ?? getenv('MYSQL_URL')) ?: null;
    }

    #[Override]
    protected static function loadDqlFunctions(Configuration $config): void
    {
        MysqlTestCase::loadDqlFunctions($config);
    }
}
