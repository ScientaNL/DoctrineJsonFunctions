<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions;

use Scienta\DoctrineJsonFunctions\Tests\Mocks\JsonFunctionMock;
use Scienta\DoctrineJsonFunctions\Tests\Query\DbTestCase;

class JsonFunctionArgumentParsingTest extends DbTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->configuration->addCustomStringFunction(JsonFunctionMock::FUNCTION_NAME,
            JsonFunctionMock::class
        );
    }

    protected function configureMock(int $reqArgCount, int $optArgCount, bool $allowOptionalRepeat)
    {
        JsonFunctionMock::$initRequiredArgumentCount = $reqArgCount;
        JsonFunctionMock::$initOptionalArgumentCount = $optArgCount;
        JsonFunctionMock::$initAllowOptionalArgumentRepeat = $allowOptionalRepeat;
    }

    public function testSimpleObjectArgument()
    {
        $this->configureMock(1, 0, false);

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK('{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK('{\"key1\":123}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testColumnArgument()
    {
        $this->configureMock(1, 0, false);

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK(j.jsonCol) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j",
            "SELECT JSON_MOCK(j0_.jsonCol) AS sclr_0 FROM JsonData j0_"
        );
    }

    public function testObjectParameterizedArguments()
    {
        $this->configureMock(1, 0, false);

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK(:foo) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK(?) AS sclr_0 FROM Blank b0_",
            ['foo' => 'bar']
        );
    }

    public function testSimpleWildcardArgument()
    {
        $this->configureMock(1, 0, false);

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK('$.*') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK('$.*') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testArrayWildcardArgument()
    {
        $this->configureMock(1, 0, false);

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK('$.papers[*].quality') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK('$.papers[*].quality') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testDoubleWildcardArgument()
    {
        $this->configureMock(1, 0, false);

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK('$**.b') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK('$**.b') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testColumnWhereArgument()
    {
        $this->configureMock(1, 0, false);

        $this->assertDqlProducesSql(
            "SELECT j.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j WHERE JSON_MOCK(j.jsonCol) IS NULL",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE JSON_MOCK(j0_.jsonCol) IS NULL"
        );
    }

    public function testColumnWildcardParamWhereArgument()
    {
        $this->configureMock(2, 0, false);

        $this->assertDqlProducesSql(
            "SELECT j.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j WHERE JSON_MOCK(j.jsonCol, '$.papers[*].quality') = 1",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE JSON_MOCK(j0_.jsonCol, '$.papers[*].quality') = 1"
        );
    }
}
