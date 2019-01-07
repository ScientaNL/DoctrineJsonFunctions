<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query;

use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\ORM\Configuration;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mariadb as DqlFunctions;
use Scienta\DoctrineJsonFunctions\Tests\Mocks\ConnectionMock;

abstract class MariadbTestCase extends DbTestCase
{
    public function setUp()
    {
        parent::setUp();

        /** @var ConnectionMock $conn */
        $conn = $this->entityManager->getConnection();
        $conn->setDatabasePlatform(new MySqlPlatform());

        self::loadDqlFunctions($this->configuration);
    }

    /**
     * @param Configuration $configuration
     */
    public static function loadDqlFunctions(Configuration $configuration)
    {
        $configuration->addCustomStringFunction(DqlFunctions\JsonValue::FUNCTION_NAME, DqlFunctions\JsonValue::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonExists::FUNCTION_NAME, DqlFunctions\JsonExists::class);
    }
}
