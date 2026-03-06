<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;

class JsonKeysTest extends MysqlTestCase
{
    public function testJsonKeys()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_KEYS('{\"a\": 1, \"b\": {\"c\": 30}}') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_KEYS('{\"a\": 1, \"b\": {\"c\": 30}}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonKeysPath()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_KEYS('{\"a\": 1, \"b\": {\"c\": 30}}', '$.b') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_KEYS('{\"a\": 1, \"b\": {\"c\": 30}}', '$.b') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testWhere(): void
    {
        $this->assertDqlProducesSql(
            "SELECT j.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j WHERE JSON_KEYS(j.jsonData) IS NOT NULL",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE JSON_KEYS(j0_.jsonData) IS NOT NULL"
        );
    }
}
