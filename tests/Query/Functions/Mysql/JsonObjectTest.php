<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;
use Doctrine\ORM\Query\Expr;

class JsonObjectTest extends MysqlTestCase
{
    public function testJsonObject()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_OBJECT('id', 87, 'name', 'carrot') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_OBJECT('id', 87, 'name', 'carrot') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonObjectEmpty()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_OBJECT() from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_OBJECT() AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonObjectBool()
    {
        $qb = $this->entityManager->createQueryBuilder();

        $query = $qb->select(new Expr\Func('JSON_OBJECT',
            [$qb->expr()->literal('id'), $qb->expr()->literal(true)]
        ))->from('Scienta\DoctrineJsonFunctions\Tests\Entities\Blank', 'b');

        $this->assertDqlProducesSql(
            $query->getDQL(),
            "SELECT JSON_OBJECT('id', 1) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonObjectCurrTime()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_OBJECT('time', CURRENT_TIME()) from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_OBJECT('time', CURRENT_TIME) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonObjectArithmeticOperator()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_OBJECT('sum', 30 + 20) from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_OBJECT('sum', 30 + 20) AS sclr_0 FROM Blank b0_"
        );
    }
}
