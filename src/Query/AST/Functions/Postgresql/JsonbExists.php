<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

/**
 * "JSONB_EXISTS" "(" StringPrimary "," StringPrimary ")"
 */
class JsonbExists extends PostgresqlJsonFunctionNode
{
	public const FUNCTION_NAME = 'JSONB_EXISTS';

    /** @var int */
    protected $requiredArgumentCount = 2;
}
