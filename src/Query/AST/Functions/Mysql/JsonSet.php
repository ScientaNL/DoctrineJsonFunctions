<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_SET" "(" StringPrimary "," StringPrimary "," StringPrimary { "," StringPrimary "," StringPrimary }* ")"
 */
class JsonSet extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_SET';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_ARG, self::STRING_ARG, self::STRING_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_ARG, self::STRING_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
