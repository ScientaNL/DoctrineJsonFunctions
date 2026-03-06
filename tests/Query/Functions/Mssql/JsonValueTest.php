<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mssql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MssqlTestCase;

class JsonValueTest extends MssqlTestCase
{
    public function testJsonValueForData(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_VALUE(j.jsonData, '$.a') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j",
            "SELECT JSON_VALUE(j0_.jsonData, '$.a') AS sclr_0 FROM JsonData j0_"
        );
    }

    public function testJsonValueForInlineJson(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_VALUE('{\"a\":42}', '$.a') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_VALUE('{\"a\":42}', '$.a') AS sclr_0 FROM Blank b0_"
        );
    }
}
