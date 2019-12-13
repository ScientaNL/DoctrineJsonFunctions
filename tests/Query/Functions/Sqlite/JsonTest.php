<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Query\SqliteTestCase;
use Doctrine\ORM\Query\Expr;

class JsonTest extends SqliteTestCase
{
    public function testJson()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON('{\"a\": 10, \"b\": false}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON('{\"a\": 10, \"b\": false}') AS sclr_0 FROM Blank b0_"
        );
    }
}
