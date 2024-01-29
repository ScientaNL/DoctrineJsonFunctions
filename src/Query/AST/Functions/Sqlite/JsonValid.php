<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Sqlite;

/**
 * "JSON_VALID" "(" StringPrimary ")"
 */
class JsonValid extends SqliteJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_VALID';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG];
}
