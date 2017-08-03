<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;


class JsonGet extends PostgresqlBinaryFunctionNode
{
	const FUNCTION_NAME = 'JSON_GET';
	const OPERATOR = '->';
}
