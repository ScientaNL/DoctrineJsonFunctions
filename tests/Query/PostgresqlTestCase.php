<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query;

use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\ORM\Configuration;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql as DqlFunctions;
use Scienta\DoctrineJsonFunctions\Tests\Mocks\ConnectionMock;
use Override;

abstract class PostgresqlTestCase extends DbTestCase
{
    #[Override]
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
        $configuration->addCustomStringFunction(DqlFunctions\JsonbExists::FUNCTION_NAME, DqlFunctions\JsonbExists::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonbExistsAll::FUNCTION_NAME, DqlFunctions\JsonbExistsAll::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonbExistsAny::FUNCTION_NAME, DqlFunctions\JsonbExistsAny::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonbInsert::FUNCTION_NAME, DqlFunctions\JsonbInsert::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonbIsContained::FUNCTION_NAME, DqlFunctions\JsonbIsContained::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonbSet::FUNCTION_NAME, DqlFunctions\JsonbSet::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonExtractPath::FUNCTION_NAME, DqlFunctions\JsonExtractPath::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonGet::FUNCTION_NAME, DqlFunctions\JsonGet::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonGetPath::FUNCTION_NAME, DqlFunctions\JsonGetPath::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonGetPathText::FUNCTION_NAME, DqlFunctions\JsonGetPathText::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonGetText::FUNCTION_NAME, DqlFunctions\JsonGetText::class);
    }
}
