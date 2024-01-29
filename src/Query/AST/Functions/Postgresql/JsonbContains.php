<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

/**
 * "JSONB_CONTAINS" "(" StringPrimary "," StringPrimary ")"
 */
class JsonbContains extends PostgresqlJsonOperatorFunctionNode
{
	public const FUNCTION_NAME = 'JSONB_CONTAINS';
	public const OPERATOR = '@>';
}
