<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;
use Doctrine\ORM\Query\Expr;

class JsonContainsPathTest extends MysqlTestCase
{
    public function testJsonContainsPathOne()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_CONTAINS_PATH('{\"a\": 1, \"b\": 2, \"c\": {\"d\": 4}}', 'ONE', '$.a', '$.e') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_CONTAINS_PATH('{\"a\": 1, \"b\": 2, \"c\": {\"d\": 4}}', 'ONE', '$.a', '$.e') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonContainsPathAll()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_CONTAINS_PATH('{\"a\": 1, \"b\": 2, \"c\": {\"d\": 4}}', 'all', '$.a', '$.e') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_CONTAINS_PATH('{\"a\": 1, \"b\": 2, \"c\": {\"d\": 4}}', 'all', '$.a', '$.e') AS sclr_0 FROM Blank b0_"
        );
    }

    /**
     * @expectedException \Doctrine\DBAL\DBALException
     */
    public function testJsonContainsPathNone()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_CONTAINS_PATH('{\"a\": 1, \"b\": 2, \"c\": {\"d\": 4}}', 'none', '$.a', '$.e') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_CONTAINS_PATH('{\"a\": 1, \"b\": 2, \"c\": {\"d\": 4}}', 'none', '$.a', '$.e') AS sclr_0 FROM Blank b0_"
        );
    }
}
