<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mariadb;

/**
 * "JSON_EXISTS" "(" StringPrimary "," StringPrimary  ")"
 */
class JsonExists extends MariadbJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_EXISTS';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG];
}
