<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_ARRAY_INSERT" "(" StringPrimary "," StringPrimary "," StringPrimary { "," StringPrimary "," StringPrimary }* ")"
 */
class JsonArrayInsert extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_ARRAY_INSERT';

    /** @var int */
    protected $requiredArgumentCount = 3;

    /** @var int */
    protected $optionalArgumentCount = 2;

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
