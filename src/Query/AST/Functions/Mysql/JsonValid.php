<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_VALID" "(" StringPrimary ")"
 */
class JsonValid extends MysqlJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_VALID';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG];
}
