<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Sqlite;

/**
 * "JSON_QUOTE" "(" Value ")"
 */
class JsonQuote extends SqliteJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_QUOTE';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::VALUE_ARG];
}
