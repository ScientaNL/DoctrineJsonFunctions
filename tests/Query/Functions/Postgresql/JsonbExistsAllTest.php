<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Postgresql;

use Scienta\DoctrineJsonFunctions\Tests\Query\PostgresqlTestCase;

class JsonbExistsAllTest extends PostgresqlTestCase
{
    public function testSelect()
    {
        $this->assertDqlProducesSql(
            "SELECT JSONB_EXISTS_ALL(d.jsonCol, '{a,b}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData d",
            "SELECT jsonb_exists_all(j0_.jsonCol, '{a,b}') AS sclr_0 FROM JsonData j0_"
        );
    }

    public function testWhere()
    {
        $this->assertDqlProducesSql(
            "SELECT d.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData d WHERE JSONB_EXISTS_ALL(d.jsonCol, '{a,b}') = true",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE jsonb_exists_all(j0_.jsonCol, '{a,b}') = true"
        );
    }
}
