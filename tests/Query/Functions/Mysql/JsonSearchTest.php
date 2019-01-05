<?php

namespace Syslogic\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Syslogic\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;
use Doctrine\ORM\Query\Expr;

class JsonSearchTest extends MysqlTestCase
{
    public function testJsonSearch()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_SEARCH('[\"abc\", [{\"k\": \"10\"}, \"def\"], {\"x\":\"abc\"}, {\"y\":\"bcd\"}]', 'one', 'abc') from Syslogic\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_SEARCH('[\"abc\", [{\"k\": \"10\"}, \"def\"], {\"x\":\"abc\"}, {\"y\":\"bcd\"}]', 'one', 'abc') AS sclr_0 FROM Blank b0_"
        );
    }
    public function testJsonSearchOne()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_SEARCH('[\"abc\", [{\"k\": \"10\"}, \"def\"], {\"x\":\"abc\"}, {\"y\":\"bcd\"}]', 'ONE', '10', NULL, '$**.k') from Syslogic\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_SEARCH('[\"abc\", [{\"k\": \"10\"}, \"def\"], {\"x\":\"abc\"}, {\"y\":\"bcd\"}]', 'ONE', '10', NULL, '$**.k') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonSearchAll()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_SEARCH('[\"abc\", [{\"k\": \"10\"}, \"def\"], {\"x\":\"abc\"}, {\"y\":\"bcd\"}]', 'all', '%b%', '', '$[0]', '$[2]') from Syslogic\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_SEARCH('[\"abc\", [{\"k\": \"10\"}, \"def\"], {\"x\":\"abc\"}, {\"y\":\"bcd\"}]', 'all', '%b%', '', '$[0]', '$[2]') AS sclr_0 FROM Blank b0_"
        );
    }

    /**
     * @expectedException \Doctrine\DBAL\DBALException
     */
    public function testJsonSearchNone()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_SEARCH('[\"abc\", [{\"k\": \"10\"}, \"def\"], {\"x\":\"abc\"}, {\"y\":\"bcd\"}]', 'none', '$.a') from Syslogic\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_SEARCH('[\"abc\", [{\"k\": \"10\"}, \"def\"], {\"x\":\"abc\"}, {\"y\":\"bcd\"}]', 'none', '$.a') AS sclr_0 FROM Blank b0_"
        );
    }

    /**
     * @expectedException \Doctrine\ORM\Query\QueryException
     */
    public function testJsonSearchOnlyEscape()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_SEARCH('[\"abc\", [{\"k\": \"10\"}, \"def\"], {\"x\":\"abc\"}, {\"y\":\"bcd\"}]', 'all', '%b%', '') from Syslogic\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_SEARCH('[\"abc\", [{\"k\": \"10\"}, \"def\"], {\"x\":\"abc\"}, {\"y\":\"bcd\"}]', 'all', '%b%', '') AS sclr_0 FROM Blank b0_"
        );
    }
}
