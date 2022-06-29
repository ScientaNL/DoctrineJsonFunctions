<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mariadb;

/**
 * "JSON_QUERY" "(" StringPrimary "," StringPrimary ")"
 */
class JsonQuery extends MariadbJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_QUERY';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG];
}
