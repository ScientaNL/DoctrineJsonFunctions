<?php

declare(strict_types=1);

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

    public function testWhere(): void
    {
        $this->assertDqlProducesSql(
            "SELECT j.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j WHERE JSON_VALUE(j.jsonData, '$.name') = 'Alice'",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE JSON_VALUE(j0_.jsonData, '$.name') = 'Alice'"
        );
    }
}
