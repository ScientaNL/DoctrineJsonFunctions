<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function implode;
use function sprintf;

/**
 * "JSON_VALUE" "(" StringPrimary "," StringPrimary "RETURNING" TypeExpression ")"
 * @example JSON_VALUE('{"item": "shoes", "price": "49.95"}', '$.price', DECIMAL(4,2))
 */
class JsonValue extends MysqlJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_VALUE';

    /** @var list<Node> */
    private array $jsonArguments = [];

    private string | null $returningType;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->jsonArguments[] = $parser->StringPrimary();

        $parser->match(TokenType::T_COMMA);

        $this->jsonArguments[] = $parser->StringPrimary();

        $parser->match(TokenType::T_COMMA);

        // match complex returning types
        $parser->match(TokenType::T_IDENTIFIER);
        $this->returningType = $parser->getLexer()->token->value;

        if ($parser->getLexer()->isNextToken(TokenType::T_OPEN_PARENTHESIS)) {
            $parser->match(TokenType::T_OPEN_PARENTHESIS);
            $parameter = $parser->Literal();
            $parameters = [$parameter->value];

            if ($parser->getLexer()->isNextToken(TokenType::T_COMMA)) {
                while ($parser->getLexer()->isNextToken(TokenType::T_COMMA)) {
                    $parser->match(TokenType::T_COMMA);
                    $parameter    = $parser->Literal();
                    $parameters[] = $parameter->value;
                }
            }

            $parser->match(TokenType::T_CLOSE_PARENTHESIS);
            $this->returningType .= '(' . implode(',', $parameters) . ')';
        }
        $argumentParsed = $this->parseArguments($parser, $this->requiredArgumentTypes);

        if (!empty($this->optionalArgumentTypes)) {
            $this->parseOptionalArguments($parser, $argumentParsed);
        }

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    /**
     * @param SqlWalker $sqlWalker
     * @return string
     * @throws Exception
     * @throws \Doctrine\ORM\Query\AST\ASTException
     */
    public function getSql(SqlWalker $sqlWalker): string
    {
        $this->validatePlatform($sqlWalker);

        /** @var list<string> $jsonStringArguments */
        $jsonStringArguments = [];
        foreach ($this->jsonArguments as $jsonArgument) {
            if ($jsonArgument === null) {
                $jsonStringArguments[] = 'NULL';
            } else {
                $jsonStringArguments[] = $jsonArgument->dispatch($sqlWalker);
            }
        }

        return sprintf(
            '%s(%s RETURNING %s)',
            $this->getSQLFunction(),
            implode(', ', $jsonStringArguments),
            $this->returningType,
        );
    }
}
