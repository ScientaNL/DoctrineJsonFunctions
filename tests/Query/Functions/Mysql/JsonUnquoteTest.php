<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;

class JsonUnquoteTest extends MysqlTestCase
{
    public function testJsonUnquote()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_UNQUOTE('\"abc\"') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_UNQUOTE('\"abc\"') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testWhere(): void
    {
        $this->assertDqlProducesSql(
            "SELECT j.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j WHERE JSON_UNQUOTE(JSON_EXTRACT(j.jsonData, '$.name')) = 'Alice'",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE JSON_UNQUOTE(JSON_EXTRACT(j0_.jsonData, '$.name')) = 'Alice'"
        );
    }
}
