<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_REPLACE" "(" StringPrimary "," StringPrimary "," StringPrimary { "," StringPrimary "," StringPrimary }* ")"
 */
class JsonReplace extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_REPLACE';

    /** @var int */
    protected $requiredArgumentCount = 3;

    /** @var int */
    protected $optionalArgumentCount = 2;

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
