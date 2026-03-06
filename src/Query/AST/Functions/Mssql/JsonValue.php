<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mssql;

/**
 * "JSON_VALUE" "(" StringPrimary "," StringPrimary ")"
 */
class JsonValue extends MssqlJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_VALUE';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG];
}
