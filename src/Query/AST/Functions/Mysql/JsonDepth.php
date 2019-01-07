<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_DEPTH" "(" StringPrimary ")"
 */
class JsonDepth extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_DEPTH';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG];
}
