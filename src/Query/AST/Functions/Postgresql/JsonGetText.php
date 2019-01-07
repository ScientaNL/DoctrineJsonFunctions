<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

/**
 * "JSON_GET_TEXT" "(" StringPrimary "," StringPrimary ")"
 */
class JsonGetText extends PostgresqlJsonOperatorFunctionNode
{
    public const FUNCTION_NAME = 'JSON_GET_TEXT';
    public const OPERATOR = '->>';
}
