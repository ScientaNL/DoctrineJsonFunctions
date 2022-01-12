<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_OVERLAPS" "(" StringPrimary "," StringPrimary ")"
 */
class JsonOverlaps extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_OVERLAPS';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG];
}
