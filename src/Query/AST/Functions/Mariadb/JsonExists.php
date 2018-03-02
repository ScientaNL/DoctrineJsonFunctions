<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mariadb;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonKeys;

/**
 * "JSON_EXISTS" "(" StringPrimary "," StringPrimary  ")"
 */
class JsonExists extends JsonKeys
{
	const FUNCTION_NAME = 'JSON_EXISTS';
}
