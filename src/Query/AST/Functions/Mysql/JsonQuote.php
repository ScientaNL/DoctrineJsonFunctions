<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_QUOTE" "(" NewValue ")"
 */
class JsonQuote extends MysqlJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_QUOTE';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::VALUE_ARG];
}
