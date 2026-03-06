<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;

class JsonValidTest extends MysqlTestCase
{
    public function testJsonValid()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_VALID('{\"a\": 1}') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_VALID('{\"a\": 1}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testWhere(): void
    {
        $this->assertDqlProducesSql(
            "SELECT j.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j WHERE JSON_VALID(j.jsonData) = 1",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE JSON_VALID(j0_.jsonData) = 1"
        );
    }
}
