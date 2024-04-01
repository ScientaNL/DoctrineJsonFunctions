<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query;

use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\ORM\Configuration;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql as DqlFunctions;
use Scienta\DoctrineJsonFunctions\Tests\Mocks\ConnectionMock;

abstract class PostgresqlTestCase extends DbTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        /** @var ConnectionMock $conn */
        $conn = $this->entityManager->getConnection();
        $conn->setDatabasePlatform(new PostgreSQLPlatform());

        self::loadDqlFunctions($this->configuration);
    }

    /**
     * @param Configuration $configuration
     */
    public static function loadDqlFunctions(Configuration $configuration)
    {
        $configuration->addCustomStringFunction(DqlFunctions\JsonbContains::FUNCTION_NAME, DqlFunctions\JsonbContains::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonbInsert::FUNCTION_NAME, DqlFunctions\JsonbInsert::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonGetText::FUNCTION_NAME, DqlFunctions\JsonGetText::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonbExistsAny::FUNCTION_NAME, DqlFunctions\JsonbExistsAny::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonbExistsAll::FUNCTION_NAME, DqlFunctions\JsonbExistsAll::class);
    }
}
