<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mariadb;

/**
 * "JSON_DETAILED" "(" StringPrimary " {, " alphaNumeric "})"
 */
class JsonDetailed extends MariadbJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_DETAILED';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::ALPHA_NUMERIC];
}
