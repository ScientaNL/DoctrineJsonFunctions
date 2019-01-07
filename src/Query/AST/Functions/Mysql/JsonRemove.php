<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_REMOVE" "(" StringPrimary "," StringPrimary {"," StringPrimary }* ")"
 */
class JsonRemove extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_REMOVE';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_PRIMARY_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
