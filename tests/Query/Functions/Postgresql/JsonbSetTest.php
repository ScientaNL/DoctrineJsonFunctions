<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Postgresql;

use Scienta\DoctrineJsonFunctions\Tests\Query\PostgresqlTestCase;

class JsonbSetTest extends PostgresqlTestCase
{
    public function testSelect(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSONB_SET(d.jsonCol,'{a}',d.jsonData) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData d",
            "SELECT jsonb_set(j0_.jsonCol, '{a}', j0_.jsonData) AS sclr_0 FROM JsonData j0_"
        );
    }

    public function testWhere(): void
    {
        $this->assertDqlProducesSql(
            "SELECT d.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData d WHERE JSONB_SET(d.jsonData, '{a}', d.jsonCol) IS NOT NULL",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE jsonb_set(j0_.jsonData, '{a}', j0_.jsonCol) IS NOT NULL"
        );
    }

    public function testSelectWithBoundValue(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSONB_SET(d.jsonCol,'{address,city}',:city) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData d",
            "SELECT jsonb_set(j0_.jsonCol, '{address,city}', ?) AS sclr_0 FROM JsonData j0_"
        );
    }

    public function testSelectWithCreateIfMissing(): void
    {
        $this->assertDqlProducesSql(
            "SELECT JSONB_SET(d.jsonCol,'{a,b}','99',false) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData d",
            "SELECT jsonb_set(j0_.jsonCol, '{a,b}', '99', false) AS sclr_0 FROM JsonData j0_"
        );
    }
}
