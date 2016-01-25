<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\MySQL57Platform;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * "JSON_SET" "(" StringPrimary "," StringPrimary "," StringPrimary { "," StringPrimary "," StringPrimary }* ")"
 */
class JsonSet extends FunctionNode
{
	const FUNCTION_NAME = 'JSON_SET';

	/**
	 * @var \Doctrine\ORM\Query\AST\Node
	 */
	public $jsonDocExpr;

	/**
	 * @var \Doctrine\ORM\Query\AST\Node
	 */
	public $firstJsonPathExpr;

	/**
	 * @var \Doctrine\ORM\Query\AST\Node
	 */
	public $firstJsonValExpr;

	/**
	 * @var \Doctrine\ORM\Query\AST\Node[]
	 */
	public $pathValExpressions = array();

	/**
	 * @param SqlWalker $sqlWalker
	 * @return string
	 * @throws DBALException
	 */
	public function getSql(SqlWalker $sqlWalker)
	{
		$jsonDoc = $sqlWalker->walkStringPrimary($this->jsonDocExpr);

		$pathVals = array();
		foreach ($this->pathValExpressions as $pathVal) {
			$pathVals[] = $sqlWalker->walkStringPrimary($pathVal);
		}

		if ($sqlWalker->getConnection()->getDatabasePlatform() instanceof MySQL57Platform)
		{
			return sprintf('%s(%s, %s)', static::FUNCTION_NAME, $jsonDoc, implode(', ', $pathVals));
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

		$parser->match(Lexer::T_COMMA);

		$this->firstJsonPathExpr = $parser->StringPrimary();
		$this->pathValExpressions[] = $this->firstJsonPathExpr;

		$parser->match(Lexer::T_COMMA);

		$this->firstJsonValExpr = $parser->StringPrimary();
		$this->pathValExpressions[] = $this->firstJsonValExpr;

		while ($parser->getLexer()->isNextToken(Lexer::T_COMMA)) {
			$parser->match(Lexer::T_COMMA);
			$this->pathValExpressions[] = $parser->StringPrimary();

			$parser->match(Lexer::T_COMMA);
			$this->pathValExpressions[] = $parser->StringPrimary();
		}

		$parser->match(Lexer::T_CLOSE_PARENTHESIS);
	}
}
