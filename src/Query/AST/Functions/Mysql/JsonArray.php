<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_ARRAY" "(" { NewValue }* ")"
 */
class JsonArray extends MysqlJsonFunctionNode
{
	public const FUNCTION_NAME = 'JSON_ARRAY';

    /** @var string[] */
    protected $optionalArgumentTypes = [self::VALUE_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
