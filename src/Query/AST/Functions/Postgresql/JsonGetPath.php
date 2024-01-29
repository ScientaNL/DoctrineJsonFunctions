<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

/**
 * "JSON_GET_PATH" "(" StringPrimary "," StringPrimary ")"
 */
class JsonGetPath extends PostgresqlJsonOperatorFunctionNode
{
    public const FUNCTION_NAME = 'JSON_GET_PATH';
	public const OPERATOR = '#>';
}
