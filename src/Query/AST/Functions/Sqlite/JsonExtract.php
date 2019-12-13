<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Sqlite;

/**
 * "JSON_EXTRACT" "(" StringPrimary "," StringPrimary {"," StringPrimary }* ")"
 */
class JsonExtract extends SqliteJsonFunctionNode
{
    const FUNCTION_NAME = 'JSON_EXTRACT';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_PRIMARY_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
