<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;

/**
 * "JSON_CONTAINS_PATH" "(" StringPrimary "," ["one" | "all"] {"," StringPrimary }* ")"
 */
class JsonContainsPath extends JsonSearch
{
	const FUNCTION_NAME = 'JSON_CONTAINS_PATH';

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

        $this->parseOptionalArguments($parser, true);

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
