<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mariadb;

use Scienta\DoctrineJsonFunctions\Tests\Query\MariadbTestCase;

class JsonDetailedTest extends MariadbTestCase
{
    public function testJsonDetailed()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_DETAILED('{\"key1\":123}') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_DETAILED('{\"key1\":123}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonDetailedMore()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_DETAILED('{\"key1\":123}', 4) from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_DETAILED('{\"key1\":123}', 4) AS sclr_0 FROM Blank b0_"
        );
    }
}
