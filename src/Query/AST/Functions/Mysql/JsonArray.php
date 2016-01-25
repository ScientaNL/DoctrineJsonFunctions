<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;

/**
 * "JSON_ARRAY" "(" { StringPrimary }* ")"
 */
class JsonArray extends JsonObject
{
	const FUNCTION_NAME = 'JSON_ARRAY';

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

			while ($parser->getLexer()->isNextToken(Lexer::T_COMMA)) {
				$parser->match(Lexer::T_COMMA);
				$this->expressions[] = $parser->StringPrimary();
			}
		}

		$parser->match(Lexer::T_CLOSE_PARENTHESIS);
	}
}
