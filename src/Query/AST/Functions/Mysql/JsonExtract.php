<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_EXTRACT" "(" StringPrimary "," StringPrimary {"," StringPrimary }* ")"
 */
class JsonExtract extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_EXTRACT';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_PRIMARY_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
