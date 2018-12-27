<?php

namespace Syslogic\DoctrineJsonFunctions\Tests\Query\Functions\Postgresql;

use Syslogic\DoctrineJsonFunctions\Tests\Query\PostgresqlTestCase;

class JsonbContainsTest extends PostgresqlTestCase
{
    public function testSelect()
    {
        $this->assertDqlProducesSql(
            "SELECT JSONB_CONTAINS(d.jsonCol,d.jsonData) FROM Syslogic\DoctrineJsonFunctions\Tests\Entities\JsonData d",
            "SELECT j0_.jsonCol @> j0_.jsonData AS sclr_0 FROM JsonData j0_"
        );
    }

    public function testWhere()
    {
        $this->assertDqlProducesSql(
            "SELECT d.id FROM Syslogic\DoctrineJsonFunctions\Tests\Entities\JsonData d WHERE JSONB_CONTAINS(d.jsonCol,d.jsonData) = true",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE j0_.jsonCol @> j0_.jsonData = true"
        );
    }
}