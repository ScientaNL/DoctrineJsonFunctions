<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query;

use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\ORM\Configuration;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql as DqlFunctions;
use Scienta\DoctrineJsonFunctions\Tests\Mocks\ConnectionMock;

abstract class MysqlTestCase extends DbTestCase
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
        $configuration->addCustomStringFunction(DqlFunctions\JsonArray::FUNCTION_NAME, DqlFunctions\JsonArray::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonArrayAppend::FUNCTION_NAME, DqlFunctions\JsonArrayAppend::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonArrayInsert::FUNCTION_NAME, DqlFunctions\JsonArrayInsert::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonContains::FUNCTION_NAME, DqlFunctions\JsonContains::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonContainsPath::FUNCTION_NAME, DqlFunctions\JsonContainsPath::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonDepth::FUNCTION_NAME, DqlFunctions\JsonDepth::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonExtract::FUNCTION_NAME, DqlFunctions\JsonExtract::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonInsert::FUNCTION_NAME, DqlFunctions\JsonInsert::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonKeys::FUNCTION_NAME, DqlFunctions\JsonKeys::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonLength::FUNCTION_NAME, DqlFunctions\JsonLength::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonMerge::FUNCTION_NAME, DqlFunctions\JsonMerge::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonMergePatch::FUNCTION_NAME, DqlFunctions\JsonMergePatch::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonObject::FUNCTION_NAME, DqlFunctions\JsonObject::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonQuote::FUNCTION_NAME, DqlFunctions\JsonQuote::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonRemove::FUNCTION_NAME, DqlFunctions\JsonRemove::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonReplace::FUNCTION_NAME, DqlFunctions\JsonReplace::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonSearch::FUNCTION_NAME, DqlFunctions\JsonSearch::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonSet::FUNCTION_NAME, DqlFunctions\JsonSet::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonType::FUNCTION_NAME, DqlFunctions\JsonType::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonUnquote::FUNCTION_NAME, DqlFunctions\JsonUnquote::class);
        $configuration->addCustomStringFunction(DqlFunctions\JsonValid::FUNCTION_NAME, DqlFunctions\JsonValid::class);
    }
}
