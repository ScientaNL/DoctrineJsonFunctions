<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mariadb;

use Scienta\DoctrineJsonFunctions\Tests\Query\MariadbTestCase;

class JsonCompactTest extends MariadbTestCase
{
    public function testJsonCompact()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_COMPACT('{\"key1\":123}') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_COMPACT('{\"key1\":123}') AS sclr_0 FROM Blank b0_"
        );
    }
}
