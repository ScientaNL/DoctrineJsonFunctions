<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;
use Doctrine\ORM\Query\Expr;

class JsonMergePatchTestTest extends MysqlTestCase
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
}
