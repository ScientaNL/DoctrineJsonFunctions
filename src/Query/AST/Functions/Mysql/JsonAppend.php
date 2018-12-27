<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_APPEND" "(" StringPrimary "," StringPrimary "," StringPrimary { "," StringPrimary "," StringPrimary }* ")"
 */
class JsonAppend extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_APPEND';

    /** @var int */
    protected $requiredArgumentCount = 3;

    /** @var int */
    protected $optionalArgumentCount = 2;

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
