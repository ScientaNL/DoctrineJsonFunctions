<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\MySQL57Platform;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * "JSON_OBJECT" "(" { StringPrimary "," StringPrimary }* ")"
 */
class JsonObject extends FunctionNode
{
	const FUNCTION_NAME = 'JSON_OBJECT';

	/**
	 * @var \Doctrine\ORM\Query\AST\Node[]
	 */
	public $expressions = array();

	/**
	 * @param SqlWalker $sqlWalker
	 * @return string
	 * @throws DBALException
	 */
	public function getSql(SqlWalker $sqlWalker)
	{
		$args = array();
		foreach ($this->expressions as $expr) {
			$args[] = $sqlWalker->walkStringPrimary($expr);
		}

		if ($sqlWalker->getConnection()->getDatabasePlatform() instanceof MySQL57Platform)
		{
			return sprintf('%s(%s)', static::FUNCTION_NAME, implode(', ', $args));
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

		if (!$parser->getLexer()->isNextToken(Lexer::T_CLOSE_PARENTHESIS)) {
			$this->expressions[] = $parser->StringPrimary();
			$parser->match(Lexer::T_COMMA);
			$this->expressions[] = $parser->StringPrimary();

			while ($parser->getLexer()->isNextToken(Lexer::T_COMMA)) {
				$parser->match(Lexer::T_COMMA);
				$this->expressions[] = $parser->StringPrimary();

				$parser->match(Lexer::T_COMMA);
				$this->expressions[] = $parser->StringPrimary();
			}
		}

		$parser->match(Lexer::T_CLOSE_PARENTHESIS);
	}
}
