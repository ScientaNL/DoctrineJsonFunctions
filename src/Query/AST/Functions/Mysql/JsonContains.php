<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * "JSON_CONTAINS" "(" StringPrimary "," StringPrimary {"," StringPrimary } ")"
 */
class JsonContains extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_CONTAINS';

    /** @var int */
    protected $requiredArgumentCount = 2;

    /** @var int */
    protected $optionalArgumentCount = 1;

    /** @var bool */
    protected $allowOptionalArgumentRepeat = false;
}
