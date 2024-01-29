<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;

class JsonMergePreserveTest extends MysqlTestCase
{
    public function testJsonMergePreserve()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_MERGE_PRESERVE('[1, 2]', '[true, false]') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MERGE_PRESERVE('[1, 2]', '[true, false]') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonMergePreserveMore()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_MERGE_PRESERVE('[1, 2]', '[true, false]', '[true, false]', '[true, false]') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MERGE_PRESERVE('[1, 2]', '[true, false]', '[true, false]', '[true, false]') AS sclr_0 FROM Blank b0_"
        );
    }
}
