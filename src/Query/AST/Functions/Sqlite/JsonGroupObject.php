<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Sqlite;

/**
 * "JSON_GROUP_OBJECT" "(" StringPrimary "," NewValue ")"
 */
class JsonGroupObject extends SqliteJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_GROUP_OBJECT';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::VALUE_ARG];
}
