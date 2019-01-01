<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_OBJECT" "(" { StringPrimary "," StringPrimary }* ")"
 */
class JsonObject extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_OBJECT';

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_ARG, self::STRING_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
