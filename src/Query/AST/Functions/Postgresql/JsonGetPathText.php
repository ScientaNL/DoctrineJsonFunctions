<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

/**
 * "JSON_GET_PATH_TEXT" "(" StringPrimary "," StringPrimary ")"
 */
class JsonGetPathText extends PostgresqlJsonOperatorFunctionNode
{
    public const FUNCTION_NAME = 'JSON_GET_PATH_TEXT';
    public const OPERATOR = '#>>';
}
