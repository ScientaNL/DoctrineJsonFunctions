<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_MERGE" "(" StringPrimary "," StringPrimary { "," StringPrimary }* ")"
 */
class JsonMerge extends MysqlAndMariadbJsonFunctionNode
{
	public const FUNCTION_NAME = 'JSON_MERGE';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG];

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_PRIMARY_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;
}
