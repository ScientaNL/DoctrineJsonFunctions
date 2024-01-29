<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query;

use Doctrine\DBAL\Platforms\MySQLPlatform;
use Doctrine\ORM\Configuration;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mariadb as DqlFunctions;
use Scienta\DoctrineJsonFunctions\Tests\Mocks\ConnectionMock;

abstract class MariadbTestCase extends DbTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        /** @var ConnectionMock $conn */
        $conn = $this->entityManager->getConnection();
        $conn->setDatabasePlatform(new MySQLPlatform());

        self::loadDqlFunctions($this->configuration);
    }

    /**
     * @param Configuration $configuration
     */
    public static function loadDqlFunctions(Configuration $configuration)
    {
        $configuration->addCustomStringFunction(DqlFunctions\JsonValue::FUNCTION_NAME, DqlFunctions\JsonValue::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonExists::FUNCTION_NAME, DqlFunctions\JsonExists::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonQuery::FUNCTION_NAME, DqlFunctions\JsonQuery::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonCompact::FUNCTION_NAME, DqlFunctions\JsonCompact::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonDetailed::FUNCTION_NAME, DqlFunctions\JsonDetailed::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonLoose::FUNCTION_NAME, DqlFunctions\JsonLoose::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonEquals::FUNCTION_NAME, DqlFunctions\JsonEquals::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonNormalize::FUNCTION_NAME, DqlFunctions\JsonNormalize::class);
    }
}
