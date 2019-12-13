<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Query\SqliteTestCase;
use Doctrine\ORM\Query\Expr;

class JsonArrayLengthTest extends SqliteTestCase
{
    public function testJsonArrayLengthList()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_ARRAY_LENGTH('[1, 2, 3]') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_ARRAY_LENGTH('[1, 2, 3]') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonArrayLengthListWithPath()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_ARRAY_LENGTH('[1, [2], 3]', '$[2]') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_ARRAY_LENGTH('[1, [2], 3]', '$[2]') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonArrayLengthDict()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_ARRAY_LENGTH('{\"a\": 1, \"b\": 2}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_ARRAY_LENGTH('{\"a\": 1, \"b\": 2}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonArrayLengthDictWithPath()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_ARRAY_LENGTH('{\"a\": 1, \"b\": [1, 2]}', '$.\"b\"') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_ARRAY_LENGTH('{\"a\": 1, \"b\": [1, 2]}', '$.\"b\"') AS sclr_0 FROM Blank b0_"
        );
    }
}
