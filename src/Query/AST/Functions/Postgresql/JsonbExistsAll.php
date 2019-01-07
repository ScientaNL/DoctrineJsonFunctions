<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

/**
 * "JSONB_EXISTS_ALL" "(" StringPrimary "," StringPrimary ")"
 */
class JsonbExistsAll extends PostgresqlJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSONB_EXISTS_ALL';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG];
}
