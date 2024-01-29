<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_LENGTH" "(" StringPrimary {"," StringPrimary } ")"
 */
class JsonLength extends MysqlJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_LENGTH';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_PRIMARY_ARG];
}
