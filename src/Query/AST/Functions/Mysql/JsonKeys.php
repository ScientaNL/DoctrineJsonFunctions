<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * "JSON_KEYS" "(" StringPrimary {"," StringPrimary } ")"
 */
class JsonKeys extends FunctionNode
{
	const FUNCTION_NAME = 'JSON_KEYS';

	/**
	 * @var \Doctrine\ORM\Query\AST\Node
	 */
	public $jsonDocExpr;

	/**
	 * @var \Doctrine\ORM\Query\AST\Node
	 */
	public $jsonPathExpr;

	/**
	 * @param SqlWalker $sqlWalker
	 * @return string
	 * @throws DBALException
	 */
	public function getSql(SqlWalker $sqlWalker)
	{
		$jsonDocExpr = $sqlWalker->walkStringPrimary($this->jsonDocExpr);

		$jsonPath = '';
		if (!empty($this->jsonPathExpr)) {
			$jsonPath = ', ' . $sqlWalker->walkStringPrimary($this->jsonPathExpr);
		}

		if ($sqlWalker->getConnection()->getDatabasePlatform() instanceof MySqlPlatform)
		{
			return sprintf('%s(%s)', static::FUNCTION_NAME, $jsonDocExpr . $jsonPath);
		}

		throw DBALException::notSupported(static::FUNCTION_NAME);
	}

	/**
	 * @param Parser $parser
	 * @throws \Doctrine\ORM\Query\QueryException
	 */
	public function parse(Parser $parser)
	{
		$parser->match(Lexer::T_IDENTIFIER);
		$parser->match(Lexer::T_OPEN_PARENTHESIS);

		$this->jsonDocExpr = $parser->StringPrimary();

		if ($parser->getLexer()->isNextToken(Lexer::T_COMMA)) {
			$parser->match(Lexer::T_COMMA);
			$this->jsonPathExpr = $parser->StringPrimary();
		}

		$parser->match(Lexer::T_CLOSE_PARENTHESIS);
	}

}
