<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonUnquoteTest extends MysqlIntegrationTestCase
{
    public function testUnquotesExtractedString(): void
    {
        $this->insertJsonData([], ['name' => 'Alice']);

        $result = $this->entityManager->createQuery(
            "SELECT JSON_UNQUOTE(JSON_EXTRACT(j.jsonData, '$.name')) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $this->assertEquals('Alice', $result);
    }
}
