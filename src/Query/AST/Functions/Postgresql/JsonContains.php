<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;


class JsonContains extends PostgresqlBinaryFunctionNode
{
	const FUNCTION_NAME = 'JSON_CONTAINS';
	const OPERATOR = '@>';
}
