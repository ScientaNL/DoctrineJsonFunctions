<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;


class JsonExists extends PostgresqlBinaryFunctionNode
{
	const FUNCTION_NAME = 'JSON_EXISTS';
	const OPERATOR = '?';
}
