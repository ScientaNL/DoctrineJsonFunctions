<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mariadb;

/**
 * "JSON_VALUE" "(" StringPrimary "," StringPrimary ")"
 */
class JsonValue extends MariadbJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_VALUE';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG];
}
