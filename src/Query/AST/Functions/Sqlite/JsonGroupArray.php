<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Sqlite;

/**
 * "JSON_GROUP_ARRAY" "(" NewValue ")"
 */
class JsonGroupArray extends SqliteJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_GROUP_ARRAY';

    /** @var string[] */
    protected $optionalArgumentTypes = [self::VALUE_ARG];
}
