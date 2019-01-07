<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mariadb;

use Scienta\DoctrineJsonFunctions\Tests\Query\MariadbTestCase;

class JsonExistsTest extends MariadbTestCase
{
    public function testJsonExists()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_EXISTS('{\"key1\":\"xxxx\", \"key2\":[1, 2, 3]}', '$.key2[10]') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_EXISTS('{\"key1\":\"xxxx\", \"key2\":[1, 2, 3]}', '$.key2[10]') AS sclr_0 FROM Blank b0_"
        );
    }
}
