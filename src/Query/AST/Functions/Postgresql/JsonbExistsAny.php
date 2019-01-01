<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

/**
 * "JSONB_EXISTS_ANY" "(" StringPrimary "," StringPrimary ")"
 */
class JsonbExistsAny extends PostgresqlJsonFunctionNode
{
	public const FUNCTION_NAME = 'JSONB_EXISTS_ANY';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_ARG, self::STRING_ARG];
}
