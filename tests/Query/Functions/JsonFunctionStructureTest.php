<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions;

use Scienta\DoctrineJsonFunctions\Tests\Mocks\JsonFunctionMock;
use Scienta\DoctrineJsonFunctions\Tests\Query\DbTestCase;

class JsonFunctionStructureTest extends DbTestCase
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

    public function testOneRequiredArgument()
    {
        $this->configureMock(1, 0, false);

        $this->assertDqlProducesSql(
            "SELECT JSON_MOCK('{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_MOCK('{\"key1\":123}') AS sclr_0 FROM Blank b0_"
        );
    }

    /**
     * @expectedException \Doctrine\ORM\Query\QueryException
     */
    public function testOneRequiredArgumentErrorsWithMore()
    {
        $this->configureMock(1, 0, false);

        $this->produceSql("SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b");
    }

    /**
     * @expectedException \Doctrine\ORM\Query\QueryException
     */
    public function testOneRequiredArgumentErrorsWithLess()
    {
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

    /**
     * @expectedException \Doctrine\ORM\Query\QueryException
     */
    public function testMoreRequiredArgumentsErrorsWithMore()
    {
        $this->configureMock(5, 0, false);

        $this->produceSql("SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b");
    }

    /**
     * @expectedException \Doctrine\ORM\Query\QueryException
     */
    public function testMoreRequiredArgumentsErrorsWithLess()
    {
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

    /**
     * @expectedException \Doctrine\ORM\Query\QueryException
     */
    public function testOneOptionalArgumentErrorsWithMore()
    {
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

    /**
     * @expectedException \Doctrine\ORM\Query\QueryException
     */
    public function testOneRequiredOneOptionalArgumentErrorsWithMore()
    {
        $this->configureMock(1, 1, false);

        $this->produceSql("SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b");
    }

    /**
     * @expectedException \Doctrine\ORM\Query\QueryException
     */
    public function testOneRequiredOneOptionalArgumentErrorsWithLess()
    {
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

    /**
     * @expectedException \Doctrine\ORM\Query\QueryException
     */
    public function testMoreOptionalArgumentsErrorsMore()
    {
        $this->configureMock(0, 2, false);

        $this->produceSql(
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b"
        );
    }

    /**
     * @expectedException \Doctrine\ORM\Query\QueryException
     */
    public function testMoreOptionalArgumentsErrorsLess()
    {
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

    /**
     * @expectedException \Doctrine\ORM\Query\QueryException
     */
    public function testMoreOptionalArgumentsErrorsRepeatingLess()
    {
        $this->configureMock(0, 3, true);

        $this->produceSql(
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b"
        );
    }

    /**
     * @expectedException \Doctrine\ORM\Query\QueryException
     */
    public function testMoreOptionalArgumentsErrorsRepeatingMore()
    {
        $this->configureMock(0, 3, true);

        $this->produceSql(
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b"
        );
    }

    /**
     * @expectedException \Doctrine\ORM\Query\QueryException
     */
    public function testMoreOptionalArgumentsErrorsRepeatingMuchMore()
    {
        $this->configureMock(0, 3, true);

        $this->produceSql(
            "SELECT JSON_MOCK('{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}', '{\"key1\":123}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b"
        );
    }
}
