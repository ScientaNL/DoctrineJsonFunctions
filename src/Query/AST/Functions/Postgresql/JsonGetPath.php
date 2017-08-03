<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;


class JsonGetPath extends PostgresqlBinaryFunctionNode
{
	const FUNCTION_NAME = 'JSON_GET_PATH';
	const OPERATOR = '#>';
}
