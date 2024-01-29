<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Mocks;

use Doctrine\ORM\Query\SqlWalker;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\AbstractJsonFunctionNode;

class JsonFunctionMock extends AbstractJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_MOCK';

    public static $initRequiredArgumentCount;
    public static $initOptionalArgumentCount;
    public static $initAllowOptionalArgumentRepeat;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        if (self::$initRequiredArgumentCount !== null) {
            $this->requiredArgumentTypes = array_fill(0, self::$initRequiredArgumentCount, self::STRING_PRIMARY_ARG);
        }
        if (self::$initOptionalArgumentCount !== null) {
            $this->optionalArgumentTypes = array_fill(0, self::$initOptionalArgumentCount, self::STRING_PRIMARY_ARG);
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
