<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Query\SqliteTestCase;
use Doctrine\ORM\Query\QueryException;

class JsonPatchTest extends SqliteTestCase
{
    public function testJsonPatch()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_PATCH('{\"a\": 10, \"b\": false}', '{\"b\": true}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_PATCH('{\"a\": 10, \"b\": false}', '{\"b\": true}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonPatchSingleArgument()
    {
        $this->expectException(QueryException::class);

        $this->assertDqlProducesSql(
            "SELECT JSON_PATCH('{\"a\": 10, \"b\": false}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "QueryException"
        );
    }
}
