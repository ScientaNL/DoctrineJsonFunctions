<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;


class JsonGetText extends PostgresqlBinaryFunctionNode
{
	const FUNCTION_NAME = 'JSON_GET_TEXT';
	const OPERATOR = '->>';
}
