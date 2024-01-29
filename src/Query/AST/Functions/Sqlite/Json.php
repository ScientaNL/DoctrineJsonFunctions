<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Sqlite;

/**
 * "JSON" "(" StringPrimary ")"
 */
class Json extends SqliteJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG];
}
