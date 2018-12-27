<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mariadb;

/**
 * "JSON_EXISTS" "(" StringPrimary "," StringPrimary  ")"
 */
class JsonExists extends MariadbJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_EXISTS';

    /** @var int */
    protected $requiredArgumentCount = 2;
}