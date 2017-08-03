<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;


class JsonbExistsAll extends PostgresqlBinaryDirectFunctionNode
{
    const FUNCTION_NAME = 'JSONB_EXISTS_ALL';
    const DIRECT_FUNCTION = 'jsonb_exists_all';
}
