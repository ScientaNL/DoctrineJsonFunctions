<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Query\SqliteTestCase;

class JsonQuoteTest extends SqliteTestCase
{
    public function testJson()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_QUOTE(3.14159) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_QUOTE(3.14159) AS sclr_0 FROM Blank b0_"
        );
    }
}
