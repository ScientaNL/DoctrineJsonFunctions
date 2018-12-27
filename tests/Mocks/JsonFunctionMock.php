<?php

namespace Syslogic\DoctrineJsonFunctions\Tests\Mocks;

use Doctrine\ORM\Query\SqlWalker;
use Syslogic\DoctrineJsonFunctions\Query\AST\Functions\AbstractJsonFunctionNode;

class JsonFunctionMock extends AbstractJsonFunctionNode
{
    const FUNCTION_NAME = 'JSON_MOCK';

    public static $initRequiredArgumentCount;
    public static $initOptionalArgumentCount;
    public static $initAllowOptionalArgumentRepeat;

    public function __construct(string $name)
    {
        if (self::$initRequiredArgumentCount !== null) {
            $this->requiredArgumentCount = self::$initRequiredArgumentCount;
        }
        if (self::$initOptionalArgumentCount !== null) {
            $this->optionalArgumentCount = self::$initOptionalArgumentCount;
        }
        if (self::$initAllowOptionalArgumentRepeat !== null) {
            $this->allowOptionalArgumentRepeat = self::$initAllowOptionalArgumentRepeat;
        }
        parent::__construct($name);
    }

    protected function validatePlatform(SqlWalker $sqlWalker): void
    {
        //do nothing
    }
}
