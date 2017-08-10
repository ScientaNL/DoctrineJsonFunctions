<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;


class JsonbExists extends PostgresqlBinaryDirectFunctionNode
{
	const FUNCTION_NAME = 'JSONB_EXISTS';
	const DIRECT_FUNCTION = 'jsonb_exists';
}
