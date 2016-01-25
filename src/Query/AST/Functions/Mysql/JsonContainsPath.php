<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\MySQL57Platform;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * "JSON_CONTAINS_PATH" "(" StringPrimary "," ["one" | "all"] {"," StringPrimary }* ")"
 */
class JsonContainsPath extends JsonSearch
{
	const FUNCTION_NAME = 'JSON_CONTAINS_PATH';

	/**
	 * @var \Doctrine\ORM\Query\AST\Node
	 */
	public $firstJsonPathExpr;

	/**
	 * @param SqlWalker $sqlWalker
	 * @return string
	 * @throws DBALException
	 */
	public function getSql(SqlWalker $sqlWalker)
	{
		$jsonDoc = $sqlWalker->walkStringPrimary($this->jsonDocExpr);
		$mode = $sqlWalker->walkStringPrimary($this->mode);

		$paths = array();
		foreach ($this->jsonPaths as $path) {
			$paths[] = $sqlWalker->walkStringPrimary($path);
		}

		if ($sqlWalker->getConnection()->getDatabasePlatform() instanceof MySQL57Platform)
		{
			return sprintf('%s(%s, %s, %s)', static::FUNCTION_NAME, $jsonDoc, $mode, implode(', ', $paths));
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

		$this->parsePathMode($parser);

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
