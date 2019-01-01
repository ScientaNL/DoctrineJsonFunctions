<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * "JSON_QUOTE" "(" StringPrimary ")"
 */
class JsonQuote extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_QUOTE';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_ARG];
}
