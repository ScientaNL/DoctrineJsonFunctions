<?php

namespace Syslogic\DoctrineJsonFunctions\Tests\Query\Functions\Mariadb;

use Syslogic\DoctrineJsonFunctions\Tests\Query\MariadbTestCase;

class JsonExistsTest extends MariadbTestCase
{
    public function testJsonExists()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_EXISTS('{\"key1\":\"xxxx\", \"key2\":[1, 2, 3]}', '$.key2[10]') from Syslogic\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_EXISTS('{\"key1\":\"xxxx\", \"key2\":[1, 2, 3]}', '$.key2[10]') AS sclr_0 FROM Blank b0_"
        );
    }
}