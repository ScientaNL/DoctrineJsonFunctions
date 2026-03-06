<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration;

use Doctrine\ORM\Configuration;
use Scienta\DoctrineJsonFunctions\Tests\Query\MssqlTestCase;
use Override;

abstract class MssqlIntegrationTestCase extends IntegrationTestCase
{
    #[Override]
    protected static function getConnectionUrl(): ?string
    {
        return ($_ENV['MSSQL_URL'] ?? getenv('MSSQL_URL')) ?: null;
    }

    #[Override]
    protected static function loadDqlFunctions(Configuration $config): void
    {
        MssqlTestCase::loadDqlFunctions($config);
    }

    /** @return array<string, mixed> */
    #[Override]
    protected static function getExtraConnectionParams(): array
    {
        return [
            'driverOptions' => ['TrustServerCertificate' => 1],
        ];
    }
}
