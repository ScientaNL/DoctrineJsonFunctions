<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_ARRAYAGG" "(" NewValue ")"
 */
class JsonArrayAgg extends MysqlJsonFunctionNode
{
    const FUNCTION_NAME = 'JSON_ARRAYAGG';

    /** @var string[] */
    protected $optionalArgumentTypes = [self::VALUE_ARG];
}
