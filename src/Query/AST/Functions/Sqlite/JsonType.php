<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Sqlite;

/**
 * "JSON_TYPE" "(" StringPrimary { "," StringPrimary } ")"
 */
class JsonType extends SqliteJsonFunctionNode
{
    const FUNCTION_NAME = 'JSON_TYPE';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_PRIMARY_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
