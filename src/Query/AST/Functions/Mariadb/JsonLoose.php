<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mariadb;

/**
 * "JSON_LOOSE" "(" StringPrimary ")"
 */
class JsonLoose extends MariadbJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_LOOSE';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG];
}
