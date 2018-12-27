<?php

namespace Syslogic\DoctrineJsonFunctions\Tests\Query\Functions\Mariadb;

use Syslogic\DoctrineJsonFunctions\Tests\Query\MariadbTestCase;

class JsonValueTest extends MariadbTestCase
{
    public function testJsonValue()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_VALUE('{\"key1\":123}', '$.key1') from Syslogic\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_VALUE('{\"key1\":123}', '$.key1') AS sclr_0 FROM Blank b0_"
        );
    }
}