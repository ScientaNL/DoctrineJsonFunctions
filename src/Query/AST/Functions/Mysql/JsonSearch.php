<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\TokenType;

/**
 * "JSON_SEARCH" "(" StringPrimary "," ["one" | "all"] "," StringPrimary {"," NewValue { "," StringPrimary }* } ")"
 */
class JsonSearch extends MysqlJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_SEARCH';

    public const MODE_ONE = 'one';

    public const MODE_ALL = 'all';

    /** @var string[] */
    protected $optionalArgumentTypes = [self::STRING_PRIMARY_ARG];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = true;

	/**
	 * @var string
	 */
	public $mode;

    /**
     * @param Parser $parser
     * @throws Exception
     * @throws \Doctrine\ORM\Query\QueryException
     */
	public function parse(Parser $parser): void
	{
		$parser->match(TokenType::T_IDENTIFIER);
		$parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->parsedArguments[] = $parser->StringPrimary();

		$parser->match(TokenType::T_COMMA);

        $this->parsedArguments[] = $this->parsePathMode($parser);

		$parser->match(TokenType::T_COMMA);

        $this->parsedArguments[] = $parser->StringPrimary();

        $continueParsing = !$parser->getLexer()->isNextToken(TokenType::T_CLOSE_PARENTHESIS);
        if ($continueParsing) {
            $this->parseArguments($parser, [self::VALUE_ARG, self::STRING_PRIMARY_ARG], true);
        }

        $this->parseOptionalArguments($parser, true);

		$parser->match(TokenType::T_CLOSE_PARENTHESIS);
	}

	/**
	 * @param Parser $parser
	 * @throws Exception
	 * @return Node
	 */
	protected function parsePathMode(Parser $parser)
	{
		$value = $parser->getLexer()->lookahead->value;

		if (strcasecmp(self::MODE_ONE, $value) === 0) {
			$this->mode = self::MODE_ONE;
			return $parser->Literal();
		}

		if (strcasecmp(self::MODE_ALL, $value) === 0) {
			$this->mode = self::MODE_ALL;
            return $parser->Literal();
		}

		throw Exception::notSupported("Mode '$value' is not supported by " . static::FUNCTION_NAME . ".");
	}
}
