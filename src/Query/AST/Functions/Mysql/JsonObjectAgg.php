<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_OBJECTAGG" "(" StringPrimary "," NewValue ")"
 */
class JsonObjectAgg extends MysqlJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_OBJECTAGG';

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_PRIMARY_ARG, self::VALUE_ARG];
}
