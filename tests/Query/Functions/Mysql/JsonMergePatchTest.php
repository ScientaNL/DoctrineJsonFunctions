<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;

class JsonMergePatchTest extends MysqlTestCase
{
    public function testJsonMergePatch()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_MERGE_PATCH('[1, 2]', '[true, false]') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MERGE_PATCH('[1, 2]', '[true, false]') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonMergePatchMore()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_MERGE_PATCH('[1, 2]', '[true, false]', '[true, false]', '[true, false]') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MERGE_PATCH('[1, 2]', '[true, false]', '[true, false]', '[true, false]') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testWhere(): void
    {
        $this->assertDqlProducesSql(
            "SELECT j.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j WHERE JSON_MERGE_PATCH(j.jsonData, j.jsonCol) IS NOT NULL",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE JSON_MERGE_PATCH(j0_.jsonData, j0_.jsonCol) IS NOT NULL"
        );
    }
}
