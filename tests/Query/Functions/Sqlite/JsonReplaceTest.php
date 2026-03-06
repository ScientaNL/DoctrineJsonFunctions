<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Query\SqliteTestCase;
use Doctrine\ORM\Query\QueryException;

class JsonReplaceTest extends SqliteTestCase
{
    public function testJsonReplaceZeroArguments()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_REPLACE('{\"a\": 1, \"b\": 2}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_REPLACE('{\"a\": 1, \"b\": 2}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonReplaceOnePairOfArguments()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_REPLACE('{\"a\": 1, \"b\": 2}', '$.\"c\"', 3) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_REPLACE('{\"a\": 1, \"b\": 2}', '$.\"c\"', 3) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonReplaceTwoPairsOfArguments()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_REPLACE('{\"a\": 1, \"b\": 2}', '$.\"c\"', 3, '$.\"d\"', 4) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_REPLACE('{\"a\": 1, \"b\": 2}', '$.\"c\"', 3, '$.\"d\"', 4) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonReplaceArgumentMismatch()
    {
        $this->expectException(QueryException::class);

        $this->assertDqlProducesSql(
            "SELECT JSON_REPLACE('{\"a\": 1, \"b\": 2}', '$.\"c\"') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "QueryException"
        );
    }

    public function testWhere(): void
    {
        $this->assertDqlProducesSql(
            "SELECT j.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j WHERE JSON_REPLACE(j.jsonData, '$.name', 'Bob') IS NOT NULL",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE JSON_REPLACE(j0_.jsonData, '$.name', 'Bob') IS NOT NULL"
        );
    }
}
