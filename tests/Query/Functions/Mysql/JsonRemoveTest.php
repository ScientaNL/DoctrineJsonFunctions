<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;

class JsonRemoveTest extends MysqlTestCase
{
    public function testJsonRemove()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_REMOVE('[\"a\", [\"b\", \"c\"], \"d\"]', '$[1]') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_REMOVE('[\"a\", [\"b\", \"c\"], \"d\"]', '$[1]') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonRemoveMore()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_REMOVE('[\"a\", [\"b\", \"c\"], \"d\"]', '$[1]', '$[0]') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_REMOVE('[\"a\", [\"b\", \"c\"], \"d\"]', '$[1]', '$[0]') AS sclr_0 FROM Blank b0_"
        );
    }
}
