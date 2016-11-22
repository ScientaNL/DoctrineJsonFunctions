<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;


class JsonGtGt extends FunctionNode
{
	const FUNCTION_NAME = 'GT_GT';
	const OPERATOR = '->>';

	/** @var \Doctrine\ORM\Query\AST\Node */
	public $jsonData;

	/** @var \Doctrine\ORM\Query\AST\Node */
	public $jsonPath;


	/**
	 * @param SqlWalker $sqlWalker
	 * @return string
	 */
	public function getSql(SqlWalker $sqlWalker)
	{
		$jsonData = $sqlWalker->walkStringPrimary($this->jsonData);
		$jsonPath = $this->jsonPath->value;

		// TODO test for PostgreSQL 9.3  (not until Doctrine\DBAL v2.6)

		if (is_numeric($jsonPath)) {
			return $jsonData . self::OPERATOR . $jsonPath;
		}
		else {
			return $jsonData . self::OPERATOR . "'$jsonPath'";
		}
	}


	/**
	 * @param Parser $parser
	 */
	public function parse(Parser $parser)
	{
		$parser->match(Lexer::T_IDENTIFIER);
		$parser->match(Lexer::T_OPEN_PARENTHESIS);

		$this->jsonData = $parser->StringPrimary();

		$parser->match(Lexer::T_COMMA);

		$this->jsonPath = $parser->StringPrimary();

		$parser->match(Lexer::T_CLOSE_PARENTHESIS);
	}
}
