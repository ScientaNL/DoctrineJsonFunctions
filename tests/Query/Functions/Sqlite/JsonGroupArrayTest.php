<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Query\SqliteTestCase;

class JsonGroupArrayTest extends SqliteTestCase
{
    public function testJsonGroupObject()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_GROUP_ARRAY('a') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_GROUP_ARRAY('a') AS sclr_0 FROM Blank b0_"
        );
    }
}
