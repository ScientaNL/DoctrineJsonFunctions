<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_OBJECT" "(" { StringPrimary "," StringPrimary }* ")"
 */
class JsonObject extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_OBJECT';

    /** @var int */
    protected $requiredArgumentCount = 0;

    /** @var int */
    protected $optionalArgumentCount = 2;

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
