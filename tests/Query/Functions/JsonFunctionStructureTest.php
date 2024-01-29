<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions;

use Scienta\DoctrineJsonFunctions\Tests\Mocks\JsonFunctionMock;
use Scienta\DoctrineJsonFunctions\Tests\Query\DbTestCase;
use Doctrine\ORM\Query\QueryException;

class JsonFunctionStructureTest extends DbTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->configuration->addCustomStringFunction(
            JsonFunctionMock::FUNCTION_NAME,
            JsonFunctionMock::class
        );
    }

    protected function configureMock(int $reqArgCount, int $optArgCount, bool $allowOptionalRepeat)
    {
        JsonFunctionMock::$initRequiredArgumentCount = $reqArgCount;
        JsonFunctionMock::$initOptionalArgumentCount = $optArgCount;
        JsonFunctionMock::$initAllowOptionalArgumentRepeat = $allowOptionalRepeat;
    }

    public function testOneRequiredArgument()
    {
        $this->configureMock(1, 0, false);

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK('{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK('{\"key1\":123}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testOneRequiredArgumentErrorsWithMore()
    {
        $this->expectException(QueryException::class);

        $this->configureMock(1, 0, false);

        $this->produceSql("SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b");
    }

    public function testOneRequiredArgumentErrorsWithLess()
    {
        $this->expectException(QueryException::class);

        $this->configureMock(1, 0, false);

        $this->produceSql("SELECT JSON_MOCK() FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b");
    }

    public function testMoreRequiredArguments()
    {
        $this->configureMock(5, 0, false);

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testMoreRequiredArgumentsErrorsWithMore()
    {
        $this->expectException(QueryException::class);

        $this->configureMock(5, 0, false);

        $this->produceSql("SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b");
    }

    public function testMoreRequiredArgumentsErrorsWithLess()
    {
        $this->expectException(QueryException::class);

        $this->configureMock(5, 0, false);

        $this->produceSql("SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b");
    }

    public function testOneOptionalArgument()
    {
        $this->configureMock(0, 1, false);

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK() FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK() AS sclr_0 FROM Blank b0_"
        );

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK('{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK('{\"key1\":123}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testOneOptionalArgumentErrorsWithMore()
    {
        $this->expectException(QueryException::class);

        $this->configureMock(0, 1, false);

        $this->produceSql("SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b");
    }

    public function testOneRequiredOneOptionalArgument()
    {
        $this->configureMock(1, 1, false);

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK('{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK('{\"key1\":123}') AS sclr_0 FROM Blank b0_"
        );

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testOneRequiredOneOptionalArgumentErrorsWithMore()
    {
        $this->expectException(QueryException::class);

        $this->configureMock(1, 1, false);

        $this->produceSql("SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b");
    }

    public function testOneRequiredOneOptionalArgumentErrorsWithLess()
    {
        $this->expectException(QueryException::class);

        $this->configureMock(1, 1, false);

        $this->produceSql("SELECT JSON_MOCK() FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b");
    }

    public function testOneRequiredOneOptionalRepeatingArgument()
    {
        $this->configureMock(1, 1, true);

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK('{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK('{\"key1\":123}') AS sclr_0 FROM Blank b0_"
        );

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testMoreOptionalArguments()
    {
        $this->configureMock(0, 2, false);

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK() FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK() AS sclr_0 FROM Blank b0_"
        );

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testMoreOptionalArgumentsErrorsMore()
    {
        $this->expectException(QueryException::class);

        $this->configureMock(0, 2, false);

        $this->produceSql(
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b"
        );
    }

    public function testMoreOptionalArgumentsErrorsLess()
    {
        $this->expectException(QueryException::class);

        $this->configureMock(0, 2, false);

        $this->produceSql(
            "SELECT JSON_MOCK('{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b"
        );
    }

    public function testOneOptionalArgumentRepeating()
    {
        $this->configureMock(0, 1, true);

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK() FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK() AS sclr_0 FROM Blank b0_"
        );

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK('{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK('{\"key1\":123}') AS sclr_0 FROM Blank b0_"
        );

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testMoreOptionalArgumentsRepeating()
    {
        $this->configureMock(0, 3, true);

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK() FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK() AS sclr_0 FROM Blank b0_"
        );

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}') AS sclr_0 FROM Blank b0_"
        );

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testMoreOptionalArgumentsErrorsRepeatingLess()
    {
        $this->expectException(QueryException::class);

        $this->configureMock(0, 3, true);

        $this->produceSql(
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b"
        );
    }

    public function testMoreOptionalArgumentsErrorsRepeatingMore()
    {
        $this->expectException(QueryException::class);

        $this->configureMock(0, 3, true);

        $this->produceSql(
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b"
        );
    }

    public function testMoreOptionalArgumentsErrorsRepeatingMuchMore()
    {
        $this->expectException(QueryException::class);

        $this->configureMock(0, 3, true);

        $this->produceSql(
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b"
        );
    }
}
