<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_ARRAY_INSERT" "(" StringPrimary "," StringPrimary "," StringPrimary { "," StringPrimary "," StringPrimary }* ")"
 */
class JsonArrayInsert extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_ARRAY_INSERT';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_ARG, self::STRING_ARG, self::STRING_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_ARG, self::STRING_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
