<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Query\SqliteTestCase;
use Doctrine\ORM\Query\QueryException;

class JsonSetTest extends SqliteTestCase
{
    public function testJsonSetZeroArguments()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_SET('{\"a\": 1, \"b\": 2}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_SET('{\"a\": 1, \"b\": 2}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonSetOnePairOfArguments()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_SET('{\"a\": 1, \"b\": 2}', '$.\"c\"', 3) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_SET('{\"a\": 1, \"b\": 2}', '$.\"c\"', 3) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonSetTwoPairsOfArguments()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_SET('{\"a\": 1, \"b\": 2}', '$.\"c\"', 3, '$.\"d\"', 4) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_SET('{\"a\": 1, \"b\": 2}', '$.\"c\"', 3, '$.\"d\"', 4) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonSetArgumentMismatch()
    {
        $this->expectException(QueryException::class);

        $this->assertDqlProducesSql(
            "SELECT JSON_SET('{\"a\": 1, \"b\": 2}', '$.\"c\"') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "QueryException"
        );
    }

    public function testWhere(): void
    {
        $this->assertDqlProducesSql(
            "SELECT j.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j WHERE JSON_SET(j.jsonData, '$.score', 0) IS NOT NULL",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE JSON_SET(j0_.jsonData, '$.score', 0) IS NOT NULL"
        );
    }
}
