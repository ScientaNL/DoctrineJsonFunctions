<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_OBJECT" "(" { string "," NewValue }* ")"
 */
class JsonObject extends MysqlJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_OBJECT';

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_ARG, self::VALUE_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
