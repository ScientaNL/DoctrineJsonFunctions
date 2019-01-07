<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

/**
 * "JSON_EXTRACT_PATH" "(" StringPrimary "," StringPrimary {"," StringPrimary }* ")"
 */
class JsonExtractPath extends PostgresqlJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_EXTRACT_PATH';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_PRIMARY_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
