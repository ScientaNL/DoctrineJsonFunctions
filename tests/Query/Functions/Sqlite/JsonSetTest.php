<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Query\SqliteTestCase;
use Doctrine\ORM\Query\Expr;

class JsonSetTest extends SqliteTestCase
{
    public function testJsonSetZeroArguments()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_SET('{\"a\": 1, \"b\": 2}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_SET('{\"a\": 1, \"b\": 2}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonSetOnePairOfArguments()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_SET('{\"a\": 1, \"b\": 2}', '$.\"c\"', 3) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_SET('{\"a\": 1, \"b\": 2}', '$.\"c\"', 3) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonSetTwoPairsOfArguments()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_SET('{\"a\": 1, \"b\": 2}', '$.\"c\"', 3, '$.\"d\"', 4) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_SET('{\"a\": 1, \"b\": 2}', '$.\"c\"', 3, '$.\"d\"', 4) AS sclr_0 FROM Blank b0_"
        );
    }

    /**
     * @expectedException \Doctrine\ORM\Query\QueryException
     */
    public function testJsonSetArgumentMismatch()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_SET('{\"a\": 1, \"b\": 2}', '$.\"c\"') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "QueryException"
        );
    }
}
