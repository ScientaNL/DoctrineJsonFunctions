<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mariadb;

/**
 * "JSON_COMPACT" "(" StringPrimary ")"
 */
class JsonCompact extends MariadbJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_COMPACT';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG];
}
