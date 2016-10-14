<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * "JSON_SEARCH" "(" StringPrimary "," ["one" | "all"] "," StringPrimary {"," StringPrimary {"," StringPrimary }* } ")"
 */
class JsonSearch extends FunctionNode
{
	const FUNCTION_NAME = 'JSON_SEARCH';

	/**
	 * @var string
	 */
	const MODE_ONE = 'one';

	/**
	 * @var string
	 */
	const MODE_ALL = 'all';

	/**
	 * @var boolean
	 */
	public $mode;

	/**
	 * @var \Doctrine\ORM\Query\AST\Node
	 */
	public $jsonDocExpr;

	/**
	 * @var \Doctrine\ORM\Query\AST\Node
	 */
	public $jsonSearchExpr;

	/**
	 * @var \Doctrine\ORM\Query\AST\Node
	 */
	public $jsonEscapeExpr;

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
		$mode = $sqlWalker->walkStringPrimary($this->mode);
		$searchArgs = $sqlWalker->walkStringPrimary($this->jsonSearchExpr);

		if (!empty($this->jsonEscapeExpr)) {
			$searchArgs .= ', ' . $sqlWalker->walkStringPrimary($this->jsonEscapeExpr);

			if (!empty($this->jsonPaths)) {
				$jsonPaths = array();
				foreach ($this->jsonPaths as $path) {
					$jsonPaths[] = $sqlWalker->walkStringPrimary($path);
				}
				$searchArgs .= ', ' . implode(', ', $jsonPaths);
			}
		}

		if ($sqlWalker->getConnection()->getDatabasePlatform() instanceof MySqlPlatform)
		{
			return sprintf('%s(%s, %s, %s)', static::FUNCTION_NAME, $jsonDoc, $mode, $searchArgs);
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

		$this->jsonSearchExpr = $parser->StringPrimary();


		if ($parser->getLexer()->isNextToken(Lexer::T_COMMA)) {
			$parser->match(Lexer::T_COMMA);
			$this->jsonEscapeExpr = $parser->StringPrimary();

			while ($parser->getLexer()->isNextToken(Lexer::T_COMMA)) {
				$parser->match(Lexer::T_COMMA);
				$this->jsonPaths[] = $parser->StringPrimary();
			}
		}

		$parser->match(Lexer::T_CLOSE_PARENTHESIS);
	}

	/**
	 * @param Parser $parser
	 * @throws DBALException
	 * @return void
	 */
	protected function parsePathMode(Parser $parser)
	{
		$lexer = $parser->getLexer();
		$value = $lexer->lookahead['value'];

		if (strcasecmp(self::MODE_ONE, $value) === 0) {
			$this->mode = self::MODE_ONE;
			$parser->StringPrimary();

			return;
		}

		if (strcasecmp(self::MODE_ALL, $value) === 0) {
			$this->mode = self::MODE_ALL;
			$parser->StringPrimary();

			return;
		}

		throw DBALException::notSupported("Mode '$value' is not supported by " . static::FUNCTION_NAME . ".");
	}
}
