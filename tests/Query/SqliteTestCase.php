<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query;

use Doctrine\DBAL\Platforms\SqlitePlatform;
use Doctrine\ORM\Configuration;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\Sqlite as DqlFunctions;
use Scienta\DoctrineJsonFunctions\Tests\Mocks\ConnectionMock;

abstract class SqliteTestCase extends DbTestCase
{
    public function setUp()
    {
        parent::setUp();

        /** @var ConnectionMock $conn */
        $conn = $this->entityManager->getConnection();
        $conn->setDatabasePlatform(new SqlitePlatform());

        self::loadDqlFunctions($this->configuration);
    }

    /**
     * @param Configuration $configuration
     */
    public static function loadDqlFunctions(Configuration $configuration)
    {
        $configuration->addCustomStringFunction(DqlFunctions\Json::FUNCTION_NAME, DqlFunctions\Json::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonArray::FUNCTION_NAME, DqlFunctions\JsonArray::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonArrayLength::FUNCTION_NAME, DqlFunctions\JsonArrayLength::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonExtract::FUNCTION_NAME, DqlFunctions\JsonExtract::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonGroupArray::FUNCTION_NAME, DqlFunctions\JsonGroupArray::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonGroupObject::FUNCTION_NAME, DqlFunctions\JsonGroupObject::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonInsert::FUNCTION_NAME, DqlFunctions\JsonInsert::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonObject::FUNCTION_NAME, DqlFunctions\JsonObject::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonPatch::FUNCTION_NAME, DqlFunctions\JsonPatch::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonQuote::FUNCTION_NAME, DqlFunctions\JsonQuote::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonRemove::FUNCTION_NAME, DqlFunctions\JsonRemove::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonReplace::FUNCTION_NAME, DqlFunctions\JsonReplace::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonSet::FUNCTION_NAME, DqlFunctions\JsonSet::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonType::FUNCTION_NAME, DqlFunctions\JsonType::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonValid::FUNCTION_NAME, DqlFunctions\JsonValid::class);
    }
}
