<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

/**
 * "JSON_GET_TEXT" "(" StringPrimary "," AlphaNumeric ")"
 */
class JsonGetText extends PostgresqlJsonOperatorFunctionNode
{
    public const FUNCTION_NAME = 'JSON_GET_TEXT';
    public const OPERATOR = '->>';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::VALUE_ARG];
}
