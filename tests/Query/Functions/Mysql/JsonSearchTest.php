<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;

class JsonSearchTest extends MysqlTestCase
{
    public function testJsonSearch()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_SEARCH('[\"abc\", [{\"k\": \"10\"}, \"def\"], {\"x\":\"abc\"}, {\"y\":\"bcd\"}]', 'one', 'abc') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_SEARCH('[\"abc\", [{\"k\": \"10\"}, \"def\"], {\"x\":\"abc\"}, {\"y\":\"bcd\"}]', 'one', 'abc') AS sclr_0 FROM Blank b0_"
        );
    }
    public function testJsonSearchOne()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_SEARCH('[\"abc\", [{\"k\": \"10\"}, \"def\"], {\"x\":\"abc\"}, {\"y\":\"bcd\"}]', 'ONE', '10', NULL, '$**.k') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_SEARCH('[\"abc\", [{\"k\": \"10\"}, \"def\"], {\"x\":\"abc\"}, {\"y\":\"bcd\"}]', 'ONE', '10', NULL, '$**.k') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonSearchAll()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_SEARCH('[\"abc\", [{\"k\": \"10\"}, \"def\"], {\"x\":\"abc\"}, {\"y\":\"bcd\"}]', 'all', '%b%', '', '$[0]', '$[2]') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_SEARCH('[\"abc\", [{\"k\": \"10\"}, \"def\"], {\"x\":\"abc\"}, {\"y\":\"bcd\"}]', 'all', '%b%', '', '$[0]', '$[2]') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonSearchNone()
    {
        $this->expectException(\Doctrine\DBAL\Exception::class);

        $this->assertDqlProducesSql(
            "SELECT JSON_SEARCH('[\"abc\", [{\"k\": \"10\"}, \"def\"], {\"x\":\"abc\"}, {\"y\":\"bcd\"}]', 'none', '$.a') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_SEARCH('[\"abc\", [{\"k\": \"10\"}, \"def\"], {\"x\":\"abc\"}, {\"y\":\"bcd\"}]', 'none', '$.a') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonSearchOnlyEscape()
    {
        $this->expectException(\Doctrine\ORM\Query\QueryException::class);

        $this->assertDqlProducesSql(
            "SELECT JSON_SEARCH('[\"abc\", [{\"k\": \"10\"}, \"def\"], {\"x\":\"abc\"}, {\"y\":\"bcd\"}]', 'all', '%b%', '') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_SEARCH('[\"abc\", [{\"k\": \"10\"}, \"def\"], {\"x\":\"abc\"}, {\"y\":\"bcd\"}]', 'all', '%b%', '') AS sclr_0 FROM Blank b0_"
        );
    }
}
