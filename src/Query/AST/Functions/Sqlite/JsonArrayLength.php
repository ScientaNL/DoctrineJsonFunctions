<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Sqlite;

/**
 * "JSON_ARRAY_LENGTH" "(" StringPrimary { "," StringPrimary } ")"
 */
class JsonArrayLength extends SqliteJsonFunctionNode
{
    const FUNCTION_NAME = 'JSON_ARRAY_LENGTH';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_PRIMARY_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
