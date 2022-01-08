<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

/**
 * "JSON_GET" "(" StringPrimary "," StringPrimary ")"
 */
class JsonGet extends PostgresqlJsonOperatorFunctionNode
{
	public const FUNCTION_NAME = 'JSON_GET';
	public const OPERATOR = '->';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::VALUE_ARG];
}
