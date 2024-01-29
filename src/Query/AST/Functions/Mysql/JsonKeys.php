<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_KEYS" "(" StringPrimary {"," StringPrimary } ")"
 */
class JsonKeys extends MysqlJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_KEYS';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_PRIMARY_ARG];
}
