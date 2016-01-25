<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_ARRAY_INSERT" "(" StringPrimary "," StringPrimary "," StringPrimary { "," StringPrimary "," StringPrimary }* ")"
 */
class JsonArrayInsert extends JsonInsert
{
	const FUNCTION_NAME = 'JSON_ARRAY_INSERT';
}
