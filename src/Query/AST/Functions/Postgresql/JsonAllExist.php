<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;


class JsonAllExist extends PostgresqlBinaryFunctionNode
{
	const FUNCTION_NAME = 'JSON_ALL_EXIST';
	const OPERATOR = '?&';
}
