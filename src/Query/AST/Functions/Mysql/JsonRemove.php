<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_REMOVE" "(" StringPrimary "," StringPrimary {"," StringPrimary }* ")"
 */
class JsonRemove extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_REMOVE';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_ARG, self::STRING_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
