<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_ARRAY_INSERT" "(" StringPrimary "," StringPrimary "," NewValue { "," StringPrimary "," NewValue }* ")"
 */
class JsonArrayInsert extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_ARRAY_INSERT';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG, self::VALUE_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_PRIMARY_ARG, self::VALUE_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
