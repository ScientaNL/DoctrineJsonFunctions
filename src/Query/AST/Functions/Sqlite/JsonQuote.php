<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Sqlite;

/**
 * "JSON_QUOTE" "(" Value ")"
 */
class JsonQuote extends SqliteJsonFunctionNode
{
    const FUNCTION_NAME = 'JSON_QUOTE';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::VALUE_ARG];
}
