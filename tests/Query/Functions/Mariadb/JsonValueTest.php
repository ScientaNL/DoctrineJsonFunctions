<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mariadb;

use Scienta\DoctrineJsonFunctions\Tests\Query\MariadbTestCase;

class JsonValueTest extends MariadbTestCase
{
    public function testJsonValue()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_VALUE('{\"key1\":123}', '$.key1') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_VALUE('{\"key1\":123}', '$.key1') AS sclr_0 FROM Blank b0_"
        );
    }
}
