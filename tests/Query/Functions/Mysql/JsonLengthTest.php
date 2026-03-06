<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;

class JsonLengthTest extends MysqlTestCase
{
    public function testJsonLength()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_LENGTH('[1, 2, {\"a\": 3}]') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_LENGTH('[1, 2, {\"a\": 3}]') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonLengthPath()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_LENGTH('{\"a\": 1, \"b\": {\"c\": 30}}', '$.b') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_LENGTH('{\"a\": 1, \"b\": {\"c\": 30}}', '$.b') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testWhere(): void
    {
        $this->assertDqlProducesSql(
            "SELECT j.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j WHERE JSON_LENGTH(j.jsonData) = 2",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE JSON_LENGTH(j0_.jsonData) = 2"
        );
    }
}
