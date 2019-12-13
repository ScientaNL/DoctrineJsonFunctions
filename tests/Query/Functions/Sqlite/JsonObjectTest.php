<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Query\SqliteTestCase;
use Doctrine\ORM\Query\Expr;

class JsonObjectTest extends SqliteTestCase
{
    public function testJsonObjectZeroArguments()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_OBJECT() FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_OBJECT() AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonObjectOnePairOfArguments()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_OBJECT('a', 1) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_OBJECT('a', 1) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonObjectTwoPairsOfArguments()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_OBJECT('a', 1, 'b', 2) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_OBJECT('a', 1, 'b', 2) AS sclr_0 FROM Blank b0_"
        );
    }

    /**
     * @expectedException \Doctrine\ORM\Query\QueryException
     */
    public function testJsonObjectArgumentMismatch()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_OBJECT('a') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "QueryException"
        );
    }
}
