<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Query\SqliteTestCase;

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

    public function testWhere(): void
    {
        $this->assertDqlProducesSql(
            "SELECT j.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j WHERE JSON_TYPE(j.jsonData) = 'object'",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE JSON_TYPE(j0_.jsonData) = 'object'"
        );
    }
}
