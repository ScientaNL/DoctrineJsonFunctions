<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Query\SqliteTestCase;
use Doctrine\ORM\Query\Expr;

class JsonValidTest extends SqliteTestCase
{
    public function testJson()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_VALID('{\"a\": 10, \"b\": false}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_VALID('{\"a\": 10, \"b\": false}') AS sclr_0 FROM Blank b0_"
        );
    }
}
