<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mariadb;

use Scienta\DoctrineJsonFunctions\Tests\Query\MariadbTestCase;

class JsonEqualsTest extends MariadbTestCase
{
    public function testJsonEquals()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_EQUALS('{\"key1\":123}', '{\"key1\":123}') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_EQUALS('{\"key1\":123}', '{\"key1\":123}') AS sclr_0 FROM Blank b0_"
        );
    }
}
