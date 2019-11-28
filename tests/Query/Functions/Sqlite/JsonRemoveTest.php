<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Query\SqliteTestCase;
use Doctrine\ORM\Query\Expr;

class JsonRemoveTest extends SqliteTestCase
{
    public function testJsonRemoveZeroArguments()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_REMOVE('{\"a\": 1, \"b\": 2}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_REMOVE('{\"a\": 1, \"b\": 2}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonSetOnePairOfArguments()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_REMOVE('{\"a\": 1, \"b\": 2}', '$.\"a\"') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_REMOVE('{\"a\": 1, \"b\": 2}', '$.\"a\"') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonSetTwoPairsOfArguments()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_REMOVE('{\"a\": 1, \"b\": 2}', '$.\"a\"', '$.\"b\"') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_REMOVE('{\"a\": 1, \"b\": 2}', '$.\"a\"', '$.\"b\"') AS sclr_0 FROM Blank b0_"
        );
    }
}
