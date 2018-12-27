<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

/**
 * "JSON_EXTRACT_PATH" "(" StringPrimary "," StringPrimary {"," StringPrimary }* ")"
 */
class JsonExtractPath extends PostgresqlJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_EXTRACT_PATH';

    /** @var int */
    protected $requiredArgumentCount = 2;

    /** @var int */
    protected $optionalArgumentCount = 1;

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
