<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\TokenType;

/**
 * "JSON_CONTAINS_PATH" "(" StringPrimary "," ["one" | "all"] {"," StringPrimary }* ")"
 */
class JsonContainsPath extends JsonSearch
{
    public const FUNCTION_NAME = 'JSON_CONTAINS_PATH';

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

        $this->parseOptionalArguments($parser, true);

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
