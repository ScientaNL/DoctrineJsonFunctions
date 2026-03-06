<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Postgresql;

use Scienta\DoctrineJsonFunctions\Tests\Query\PostgresqlTestCase;

class JsonbInsertTest extends PostgresqlTestCase
{
    public function testSelect()
    {
        $this->assertDqlProducesSql(
            "SELECT JSONB_INSERT(d.jsonCol,'{0}',d.jsonData) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData d",
            "SELECT jsonb_insert(j0_.jsonCol, '{0}', j0_.jsonData) AS sclr_0 FROM JsonData j0_"
        );
    }

    public function testWhere(): void
    {
        $this->assertDqlProducesSql(
            "SELECT d.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData d WHERE JSONB_INSERT(d.jsonData, '{0}', d.jsonCol) IS NOT NULL",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE jsonb_insert(j0_.jsonData, '{0}', j0_.jsonCol) IS NOT NULL"
        );
    }
}
