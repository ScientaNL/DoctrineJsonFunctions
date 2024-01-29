<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;

class JsonTypeTest extends MysqlTestCase
{
    public function testJsonType()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_DEPTH('{}') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_DEPTH('{}') AS sclr_0 FROM Blank b0_"
        );
    }
}
