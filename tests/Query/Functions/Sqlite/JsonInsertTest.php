<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Query\SqliteTestCase;

class JsonInsertTest extends SqliteTestCase
{
    public function testJsonInsertZeroArguments()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_INSERT('{\"a\": 1, \"b\": 2}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_INSERT('{\"a\": 1, \"b\": 2}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonInsertOnePairOfArguments()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_INSERT('{\"a\": 1, \"b\": 2}', '$.\"c\"', 3) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_INSERT('{\"a\": 1, \"b\": 2}', '$.\"c\"', 3) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonInsertTwoPairsOfArguments()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_INSERT('{\"a\": 1, \"b\": 2}', '$.\"c\"', 3, '$.\"d\"', 4) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_INSERT('{\"a\": 1, \"b\": 2}', '$.\"c\"', 3, '$.\"d\"', 4) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonInsertArgumentMismatch()
    {
        $this->expectException(\Doctrine\ORM\Query\QueryException::class);

        $this->assertDqlProducesSql(
            "SELECT JSON_INSERT('{\"a\": 1, \"b\": 2}', '$.\"c\"') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "QueryException"
        );
    }
}
