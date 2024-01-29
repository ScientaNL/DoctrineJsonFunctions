<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mariadb;

use Scienta\DoctrineJsonFunctions\Tests\Query\MariadbTestCase;

class JsonQueryTest extends MariadbTestCase
{
    public function testJsonQuery()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_QUERY('{\"key1\":123}', '$.key1') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_QUERY('{\"key1\":123}', '$.key1') AS sclr_0 FROM Blank b0_"
        );
    }
}
