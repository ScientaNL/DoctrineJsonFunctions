<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_REPLACE" "(" StringPrimary "," StringPrimary "," StringPrimary { "," StringPrimary "," StringPrimary }* ")"
 */
class JsonReplace extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_REPLACE';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_ARG, self::STRING_ARG, self::STRING_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_ARG, self::STRING_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
