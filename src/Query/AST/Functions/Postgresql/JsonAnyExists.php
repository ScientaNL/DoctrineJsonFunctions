<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;


class JsonAnyExists extends PostgresqlBinaryFunctionNode
{
	const FUNCTION_NAME = 'JSON_ANY_EXISTS';
	const OPERATOR = '?|';
}
