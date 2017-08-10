<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\PostgreSQL92Platform;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * "JSON_EXTRACT_PATH" "(" StringPrimary "," StringPrimary {"," StringPrimary }* ")"
 */
class JsonExtractPath extends FunctionNode
{
	/**
	 * @var \Doctrine\ORM\Query\AST\Node
	 */
	public $jsonData;

	/**
	 * @var \Doctrine\ORM\Query\AST\Node
	 */
	public $firstJsonPath;

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
		$jsonData = $sqlWalker->walkStringPrimary($this->jsonData);

		$jsonPaths = array();

		foreach ($this->jsonPaths as $path) {
			$jsonPaths[] = $path->dispatch($sqlWalker);
		}

		if ($sqlWalker->getConnection()->getDatabasePlatform() instanceof PostgreSQL92Platform) {
			return 'json_extract_path(' . $jsonData . ', ' . join(', ', (array) $jsonPaths) . ')';
		}

		throw DBALException::notSupported('JSON_EXTRACT_PATH');
	}

	/**
	 * @param Parser $parser
	 * @throws \Doctrine\ORM\Query\QueryException
	 */
	public function parse(Parser $parser)
	{
		$parser->match(Lexer::T_IDENTIFIER);
		$parser->match(Lexer::T_OPEN_PARENTHESIS);

		$this->jsonData = $parser->StringPrimary();

		$parser->match(Lexer::T_COMMA);

		$this->firstJsonPath = $parser->StringPrimary();
		$this->jsonPaths[] = $this->firstJsonPath;

		while ($parser->getLexer()->isNextToken(Lexer::T_COMMA)) {
			$parser->match(Lexer::T_COMMA);
			$this->jsonPaths[] = $parser->StringPrimary();
		}

		$parser->match(Lexer::T_CLOSE_PARENTHESIS);
	}

}
