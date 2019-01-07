<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;
use Doctrine\ORM\Query\Expr;

class JsonArrayTest extends MysqlTestCase
{
    public function testJsonArray()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_ARRAY(1, 'abc', NULL, b.id, CURRENT_TIME(), CONCAT('a','my')) from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_ARRAY(1, 'abc', NULL, b0_.id, CURRENT_TIME, CONCAT('a', 'my')) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonArrayEmpty()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_ARRAY() from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_ARRAY() AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonArrayBool()
    {
        $qb = $this->entityManager->createQueryBuilder();

        $query = $qb->select(new Expr\Func('JSON_ARRAY', [$qb->expr()->literal(true)]))
            ->from('Scienta\DoctrineJsonFunctions\Tests\Entities\Blank', 'b');

        $this->assertDqlProducesSql(
            $query->getDQL(),
            "SELECT JSON_ARRAY(1) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonArrayCurrTime()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_ARRAY(CURRENT_TIME()) from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_ARRAY(CURRENT_TIME) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonArrayArithmeticOperator()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_ARRAY(30 + 20) from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_ARRAY(30 + 20) AS sclr_0 FROM Blank b0_"
        );
    }
}
