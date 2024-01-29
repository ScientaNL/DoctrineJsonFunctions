<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Sqlite;

/**
 * "JSON_OBJECT" "(" { StringPrimary "," Value "," }* ")"
 */
class JsonObject extends SqliteJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_OBJECT';

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_PRIMARY_ARG, self::VALUE_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
