<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

/**
 * "JSONB_INSERT" "(" StringPrimary "," StringPrimary "," StringPrimary ")".
 */
class JsonbInsert extends PostgresqlJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSONB_INSERT';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_PRIMARY_ARG];
}
