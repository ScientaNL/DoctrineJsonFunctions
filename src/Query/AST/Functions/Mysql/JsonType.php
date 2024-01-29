<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_TYPE" "(" StringPrimary ")"
 */
class JsonType extends MysqlJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_TYPE';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG];
}
