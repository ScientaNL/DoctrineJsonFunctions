<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;

/**
 * "JSON_SEARCH" "(" StringPrimary "," ["one" | "all"] "," StringPrimary {"," StringPrimary }* } ")"
 */
class JsonSearch extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_SEARCH';

	const MODE_ONE = 'one';

	const MODE_ALL = 'all';

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;

	/**
	 * @var boolean
	 */
	public $mode;

    /**
     * @param Parser $parser
     * @throws DBALException
     * @throws \Doctrine\ORM\Query\QueryException
     */
	public function parse(Parser $parser): void
	{
		$parser->match(Lexer::T_IDENTIFIER);
		$parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->parsedArguments[] = $parser->StringPrimary();

		$parser->match(Lexer::T_COMMA);

        $this->parsedArguments[] = $this->parsePathMode($parser);

		$parser->match(Lexer::T_COMMA);

        $this->parsedArguments[] = $parser->StringPrimary();

        $parser->match(Lexer::T_COMMA);

        $this->parseOptionalArguments($parser, true);

		$parser->match(Lexer::T_CLOSE_PARENTHESIS);
	}

	/**
	 * @param Parser $parser
	 * @throws DBALException
	 * @return Node
	 */
	protected function parsePathMode(Parser $parser)
	{
		$value = $parser->getLexer()->lookahead['value'];

		if (strcasecmp(self::MODE_ONE, $value) === 0) {
			$this->mode = self::MODE_ONE;
			return $parser->StringPrimary();
		}

		if (strcasecmp(self::MODE_ALL, $value) === 0) {
			$this->mode = self::MODE_ALL;
            return $parser->StringPrimary();
		}

		throw DBALException::notSupported("Mode '$value' is not supported by " . static::FUNCTION_NAME . ".");
	}
}
