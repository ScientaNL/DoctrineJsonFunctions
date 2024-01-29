<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_ARRAYAGG" "(" NewValue ")"
 */
class JsonArrayAgg extends MysqlJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_ARRAYAGG';

    /** @var string[] */
    protected $optionalArgumentTypes = [self::VALUE_ARG];
}
