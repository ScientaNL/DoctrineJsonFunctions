<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_CONTAINS" "(" StringPrimary "," StringPrimary {"," StringPrimary } ")"
 */
class JsonContains extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_CONTAINS';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_PRIMARY_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = false;
}
