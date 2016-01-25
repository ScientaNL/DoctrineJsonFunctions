<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_INSERT" "(" StringPrimary "," StringPrimary "," StringPrimary { "," StringPrimary "," StringPrimary }* ")"
 */
class JsonInsert extends JsonSet
{
	const FUNCTION_NAME = 'JSON_INSERT';
}
