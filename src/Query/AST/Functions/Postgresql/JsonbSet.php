<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

/**
 * "JSONB_SET" "(" StringPrimary "," StringPrimary "," StringPrimary ["," NewValue] ")".
 */
class JsonbSet extends PostgresqlJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSONB_SET';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::VALUE_ARG];
}
