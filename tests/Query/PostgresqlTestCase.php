<?php

namespace Syslogic\DoctrineJsonFunctions\Tests\Query;

use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\ORM\Configuration;
use Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql as DqlFunctions;
use Syslogic\DoctrineJsonFunctions\Tests\Mocks\ConnectionMock;

abstract class PostgresqlTestCase extends DbTestCase
{
    public function setUp()
    {
        parent::setUp();

        /** @var ConnectionMock $conn */
        $conn = $this->entityManager->getConnection();
        $conn->setDatabasePlatform(new PostgreSqlPlatform());

        self::loadDqlFunctions($this->configuration);
    }

    /**
     * @param Configuration $configuration
     */
    public static function loadDqlFunctions(Configuration $configuration)
    {
        $configuration->addCustomStringFunction(DqlFunctions\JsonbContains::FUNCTION_NAME, DqlFunctions\JsonbContains::class);
    }
}