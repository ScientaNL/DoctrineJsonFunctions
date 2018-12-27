<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

/**
 * "JSONB_EXISTS_ALL" "(" StringPrimary "," StringPrimary ")"
 */
class JsonbExistsAll extends PostgresqlJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSONB_EXISTS_ALL';

    /** @var int */
    protected $requiredArgumentCount = 2;
}
