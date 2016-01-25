<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_ARRAY_APPEND" "(" StringPrimary "," StringPrimary "," StringPrimary { "," StringPrimary "," StringPrimary }* ")"
 */
class JsonArrayAppend extends JsonAppend
{
	const FUNCTION_NAME = 'JSON_ARRAY_APPEND';
}
