<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

/**
 * "JSONB_EXISTS" "(" StringPrimary "," StringPrimary ")"
 */
class JsonbExists extends PostgresqlJsonFunctionNode
{
	public const FUNCTION_NAME = 'JSONB_EXISTS';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG];
}
