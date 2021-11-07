<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_QUOTE" "(" NewValue ")"
 */
class JsonQuote extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_QUOTE';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::VALUE_ARG];
}
