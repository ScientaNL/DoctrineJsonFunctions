<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mariadb;

use Scienta\DoctrineJsonFunctions\Tests\Query\MariadbTestCase;

class JsonLooseTest extends MariadbTestCase
{
    public function testJsonLoose()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_LOOSE('{\"key1\":123}') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_LOOSE('{\"key1\":123}') AS sclr_0 FROM Blank b0_"
        );
    }
}
