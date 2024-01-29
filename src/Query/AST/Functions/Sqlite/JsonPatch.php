<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Sqlite;

/**
 * "JSON_PATCH" "(" StringPrimary "," StringPrimary ")"
 */
class JsonPatch extends SqliteJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_PATCH';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG];
}
