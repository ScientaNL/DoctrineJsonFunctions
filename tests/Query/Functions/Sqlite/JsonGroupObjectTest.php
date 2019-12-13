<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Query\SqliteTestCase;
use Doctrine\ORM\Query\Expr;

class JsonGroupObjectTest extends SqliteTestCase
{
    public function testJsonGroupObject()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_GROUP_OBJECT('a', 1) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_GROUP_OBJECT('a', 1) AS sclr_0 FROM Blank b0_"
        );
    }

    /**
     * @expectedException \Doctrine\ORM\Query\QueryException
     */
    public function testJsonGroupObjectMissingParameter()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_GROUP_OBJECT('a') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_GROUP_OBJECT('a') AS sclr_0 FROM Blank b0_"
        );
    }
}
