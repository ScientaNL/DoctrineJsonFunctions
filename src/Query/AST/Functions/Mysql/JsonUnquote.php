<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_UNQUOTE" "(" StringPrimary ")"
 */
class JsonUnquote extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_UNQUOTE';
}
