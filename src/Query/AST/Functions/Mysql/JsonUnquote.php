<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_UNQUOTE" "(" StringPrimary ")"
 */
class JsonUnquote extends MysqlJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_UNQUOTE';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG];
}
