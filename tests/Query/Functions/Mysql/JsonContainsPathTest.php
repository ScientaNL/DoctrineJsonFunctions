<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;
use Doctrine\DBAL\Exception;

class JsonContainsPathTest extends MysqlTestCase
{
    public function testJsonContainsPathOne()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_CONTAINS_PATH('{\"a\": 1, \"b\": 2, \"c\": {\"d\": 4}}', 'ONE', '$.a', '$.e') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_CONTAINS_PATH('{\"a\": 1, \"b\": 2, \"c\": {\"d\": 4}}', 'ONE', '$.a', '$.e') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonContainsPathAll()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_CONTAINS_PATH('{\"a\": 1, \"b\": 2, \"c\": {\"d\": 4}}', 'all', '$.a', '$.e') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_CONTAINS_PATH('{\"a\": 1, \"b\": 2, \"c\": {\"d\": 4}}', 'all', '$.a', '$.e') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonContainsPathNone()
    {
        $this->expectException(Exception::class);

        $this->assertDqlProducesSql(
            "SELECT JSON_CONTAINS_PATH('{\"a\": 1, \"b\": 2, \"c\": {\"d\": 4}}', 'none', '$.a', '$.e') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_CONTAINS_PATH('{\"a\": 1, \"b\": 2, \"c\": {\"d\": 4}}', 'none', '$.a', '$.e') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testWhere(): void
    {
        $this->assertDqlProducesSql(
            "SELECT j.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j WHERE JSON_CONTAINS_PATH(j.jsonData, 'one', '$.name') = 1",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE JSON_CONTAINS_PATH(j0_.jsonData, 'one', '$.name') = 1"
        );
    }
}
