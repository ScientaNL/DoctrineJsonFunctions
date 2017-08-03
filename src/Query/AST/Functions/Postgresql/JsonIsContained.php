<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;


class JsonIsContained extends PostgresqlBinaryFunctionNode
{
	const FUNCTION_NAME = 'JSON_IS_CONTAINED';
	const OPERATOR = '<@';
}
