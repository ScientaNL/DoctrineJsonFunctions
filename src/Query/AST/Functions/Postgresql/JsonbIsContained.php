<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

/**
 * "JSONB_IS_CONTAINED" "(" StringPrimary "," StringPrimary ")"
 */
class JsonbIsContained extends PostgresqlJsonOperatorFunctionNode
{
	public const FUNCTION_NAME = 'JSONB_IS_CONTAINED';
	public const OPERATOR = '<@';
}
