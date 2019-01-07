<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

/**
 * "JSONB_EXISTS_ANY" "(" StringPrimary "," StringPrimary ")"
 */
class JsonbExistsAny extends PostgresqlJsonFunctionNode
{
	public const FUNCTION_NAME = 'JSONB_EXISTS_ANY';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG];
}
