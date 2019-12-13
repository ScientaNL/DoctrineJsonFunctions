<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Query\SqliteTestCase;
use Doctrine\ORM\Query\Expr;

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

    /**
     * @expectedException \Doctrine\ORM\Query\QueryException
     */
    public function testJsonReplaceArgumentMismatch()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_REPLACE('{\"a\": 1, \"b\": 2}', '$.\"c\"') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "QueryException"
        );
    }
}
