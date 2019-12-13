<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Sqlite;

/**
 * "JSON_REPLACE" "(" StringPrimary { "," StringPrimary "," Value }* ")"
 */
class JsonReplace extends SqliteJsonFunctionNode
{
    const FUNCTION_NAME = 'JSON_REPLACE';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_PRIMARY_ARG, self::VALUE_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
