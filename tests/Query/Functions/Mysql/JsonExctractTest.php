<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;
use Doctrine\ORM\Query\QueryException;

class JsonExctractTest extends MysqlTestCase
{
    public function testJsonExtractSpace()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_EXTRACT('{ \"a b\": 10, \"b\": false}', '$.\"a b\"') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_EXTRACT('{ \"a b\": 10, \"b\": false}', '$.\"a b\"') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonExtractQuotes()
    {
        $this->expectException(QueryException::class);

        $this->assertDqlProducesSql(
            'SELECT JSON_EXTRACT(d.jsonData, "$.a") FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData d',
            "QueryException"
        );
    }

    public function testWhere(): void
    {
        $this->assertDqlProducesSql(
            "SELECT j.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j WHERE JSON_EXTRACT(j.jsonData, '$.score') = 42",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE JSON_EXTRACT(j0_.jsonData, '$.score') = 42"
        );
    }
}
