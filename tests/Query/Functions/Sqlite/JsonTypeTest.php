<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Query\SqliteTestCase;
use Doctrine\ORM\Query\Expr;

class JsonTypeTest extends SqliteTestCase
{
    public function testJsonType()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_TYPE('[1, 2, 3]') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_TYPE('[1, 2, 3]') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonTypeWithPath()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_TYPE('[1, \"2\", 3]', '$[2]') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_TYPE('[1, \"2\", 3]', '$[2]') AS sclr_0 FROM Blank b0_"
        );
    }
}
