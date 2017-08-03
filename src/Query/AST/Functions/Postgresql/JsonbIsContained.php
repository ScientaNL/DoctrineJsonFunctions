<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;


class JsonbIsContained extends PostgresqlBinaryFunctionNode
{
	const FUNCTION_NAME = 'JSONB_IS_CONTAINED';
	const OPERATOR = '<@';
}
