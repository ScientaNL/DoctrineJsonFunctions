<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;


class JsonbContains extends PostgresqlBinaryFunctionNode
{
	const FUNCTION_NAME = 'JSONB_CONTAINS';
	const OPERATOR = '@>';
}
