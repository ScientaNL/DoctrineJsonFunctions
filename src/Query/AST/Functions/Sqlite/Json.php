<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Sqlite;

/**
 * "JSON" "(" StringPrimary ")"
 */
class Json extends SqliteJsonFunctionNode
{
    const FUNCTION_NAME = 'JSON';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG];
}
