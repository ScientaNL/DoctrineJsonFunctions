<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_PRETTY" "(" NewValue ")"
 */
class JsonPretty extends MysqlJsonFunctionNode
{
    const FUNCTION_NAME = 'JSON_PRETTY';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::VALUE_ARG];
}
