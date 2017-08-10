<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;


class JsonGetPathText extends PostgresqlBinaryFunctionNode
{
	const FUNCTION_NAME = 'JSON_GET_PATH_TEXT';
	const OPERATOR = '#>>';
}
