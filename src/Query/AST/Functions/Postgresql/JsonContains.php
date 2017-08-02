<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;


class JsonContains extends PostgresqlBinaryFunctionNode
{
	const FUNCTION_NAME = 'JSON_CONTAINS';
	const OPERATOR = '@>';

	/** @var \Doctrine\ORM\Query\AST\Node */
	public $jsonData;

	/** @var \Doctrine\ORM\Query\AST\Node */
	public $jsonPath;


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
