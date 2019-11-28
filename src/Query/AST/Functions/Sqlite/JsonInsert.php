<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Sqlite;

/**
 * "JSON_INSERT" "(" StringPrimary { "," StringPrimary "," Value }* ")"
 */
class JsonInsert extends SqliteJsonFunctionNode
{
    const FUNCTION_NAME = 'JSON_INSERT';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_PRIMARY_ARG, self::VALUE_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
