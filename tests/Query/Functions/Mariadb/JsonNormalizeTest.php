<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mariadb;

use Scienta\DoctrineJsonFunctions\Tests\Query\MariadbTestCase;

class JsonNormalizeTest extends MariadbTestCase
{
    public function testJsonNormalize()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_NORMALIZE('{\"key1\":123}') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_NORMALIZE('{\"key1\":123}') AS sclr_0 FROM Blank b0_"
        );
    }
}
