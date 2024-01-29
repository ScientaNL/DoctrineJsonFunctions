<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Sqlite;

/**
 * "JSON_REMOVE" "(" StringPrimary { "," StringPrimary }* ")"
 */
class JsonRemove extends SqliteJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_REMOVE';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_PRIMARY_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
