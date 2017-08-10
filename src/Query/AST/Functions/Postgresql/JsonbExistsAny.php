<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;


class JsonbExistsAny extends PostgresqlBinaryDirectFunctionNode
{
	const FUNCTION_NAME = 'JSONB_EXISTS_ANY';
	const DIRECT_FUNCTION = 'jsonb_exists_any';
}
