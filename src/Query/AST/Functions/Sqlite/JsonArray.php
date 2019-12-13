<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Sqlite;

/**
 * "JSON_ARRAY" "(" { StringPrimary ","}* ")"
 */
class JsonArray extends SqliteJsonFunctionNode
{
    const FUNCTION_NAME = 'JSON_ARRAY';

    /** @var string[] */
    protected $optionalArgumentTypes = [self::VALUE_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
