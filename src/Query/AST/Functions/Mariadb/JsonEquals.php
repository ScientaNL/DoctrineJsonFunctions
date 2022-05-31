<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mariadb;

/**
 * "JSON_EQUALS" "(" StringPrimary ", " StringPrimary ")"
 */
class JsonEquals extends MariadbJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_EQUALS';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG];
}
