<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * "JSON_EXTRACT" "(" StringPrimary "," StringPrimary {"," StringPrimary }* ")"
 */
class JsonExtract extends FunctionNode
{
	const FUNCTION_NAME = 'JSON_EXTRACT';

	/**
	 * @var \Doctrine\ORM\Query\AST\Node
	 */
	public $jsonDocExpr;

	/**
	 * @var \Doctrine\ORM\Query\AST\Node
	 */
	public $firstJsonPathExpr;

	/**
	 * @var \Doctrine\ORM\Query\AST\Node[]
	 */
	public $jsonPaths = array();

	/**
	 * @param SqlWalker $sqlWalker
	 * @return string
	 * @throws DBALException
	 */
	public function getSql(SqlWalker $sqlWalker)
	{
		$jsonDoc = $sqlWalker->walkStringPrimary($this->jsonDocExpr);

		$paths = array();
		foreach ($this->jsonPaths as $path) {
			$paths[] = $sqlWalker->walkStringPrimary($path);
		}

		if ($sqlWalker->getConnection()->getDatabasePlatform() instanceof MySqlPlatform)
		{
			return sprintf('%s(%s, %s)', static::FUNCTION_NAME, $jsonDoc, implode(', ', $paths));
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
		$this->jsonPaths[] = $this->firstJsonPathExpr;

		while ($parser->getLexer()->isNextToken(Lexer::T_COMMA)) {
			$parser->match(Lexer::T_COMMA);
			$this->jsonPaths[] = $parser->StringPrimary();
		}

		$parser->match(Lexer::T_CLOSE_PARENTHESIS);
	}

}
