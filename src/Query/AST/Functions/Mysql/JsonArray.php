<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_ARRAY" "(" { StringPrimary }* ")"
 */
class JsonArray extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_ARRAY';

    /** @var int */
    protected $requiredArgumentCount = 0;

    /** @var int */
    protected $optionalArgumentCount = 1;

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
