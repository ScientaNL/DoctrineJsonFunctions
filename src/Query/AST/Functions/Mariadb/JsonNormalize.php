<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mariadb;

/**
 * "JSON_NORMALIZE" "(" StringPrimary ")"
 */
class JsonNormalize extends MariadbJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_NORMALIZE';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG];
}
