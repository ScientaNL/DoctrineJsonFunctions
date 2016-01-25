<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_REMOVE" "(" StringPrimary "," StringPrimary "," StringPrimary { "," StringPrimary "," StringPrimary }* ")"
 */
class JsonRemove extends JsonExtract
{
	const FUNCTION_NAME = 'JSON_REMOVE';
}
