<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_MERGE_PATCH" "(" StringPrimary "," StringPrimary { "," StringPrimary }* ")"
 */
class JsonMergePatch extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_MERGE_PATCH';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_PRIMARY_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
