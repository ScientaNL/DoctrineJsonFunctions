<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Literal;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;

abstract class AbstractJsonFunctionNode extends FunctionNode
{
    public const FUNCTION_NAME = null;

    protected const ALPHA_NUMERIC = 'alphaNumeric';
    protected const STRING_PRIMARY_ARG = 'stringPrimary';
    protected const STRING_ARG = 'string';
    protected const VALUE_ARG = 'newValue';

    /** @var string[] */
    protected $requiredArgumentTypes = [];

    /** @var string[] */
    protected $optionalArgumentTypes = [];

    /** @var bool */
    protected $allowOptionalArgumentRepeat = false;

    /** @var Node[] */
    protected $parsedArguments = [];

    /**
     * @param Parser $parser
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function parse(Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $argumentParsed = $this->parseArguments($parser, $this->requiredArgumentTypes);

        if (!empty($this->optionalArgumentTypes)) {
            $this->parseOptionalArguments($parser, $argumentParsed);
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * @param Parser $parser
     * @param bool $argumentParsed
     * @throws \Doctrine\ORM\Query\QueryException
     */
    protected function parseOptionalArguments(Parser $parser, bool $argumentParsed): void
    {
        $continueParsing = !$parser->getLexer()->isNextToken(Lexer::T_CLOSE_PARENTHESIS);
        while ($continueParsing) {
            $argumentParsed = $this->parseArguments($parser, $this->optionalArgumentTypes, $argumentParsed);
            $continueParsing = $this->allowOptionalArgumentRepeat && $parser->getLexer()->isNextToken(Lexer::T_COMMA);
        }
    }

    /**
     * @param Parser $parser
     * @param string[] $argumentTypes
     * @param bool $argumentParsed
     * @return bool
     * @throws \Doctrine\ORM\Query\QueryException
     */
    protected function parseArguments(Parser $parser, array $argumentTypes, bool $argumentParsed = false): bool
    {
        foreach ($argumentTypes as $argType) {
            if ($argumentParsed) {
                $parser->match(Lexer::T_COMMA);
            } else {
                $argumentParsed = true;
            }

            switch ($argType) {
                case self::STRING_PRIMARY_ARG:
                    $this->parsedArguments[] = $parser->StringPrimary();
                    break;
                case self::STRING_ARG:
                    $this->parsedArguments[] = $this->parseStringLiteral($parser);
                    break;
                case self::ALPHA_NUMERIC:
                    $this->parsedArguments[] = $this->parseAlphaNumericLiteral($parser);
                    break;
                case self::VALUE_ARG:
                    $this->parsedArguments[] = $parser->NewValue();
                    break;
                default:
                    throw QueryException::semanticalError(sprintf('Unknown function argument type %s for %s()', $argType, static::FUNCTION_NAME));
            }
        }

        return $argumentParsed;
    }

    /**
     * @param Parser $parser
     * @return Literal
     * @throws QueryException
     */
    protected function parseStringLiteral(Parser $parser): Literal
    {
        $lexer = $parser->getLexer();
        $lookaheadType = $lexer->lookahead['type'];

        if ($lookaheadType != Lexer::T_STRING) {
            $parser->syntaxError('string');
        }

        return $this->matchStringLiteral($parser, $lexer);
    }

    /**
     * @param Parser $parser
     * @return Literal
     * @throws QueryException
     */
    protected function parseAlphaNumericLiteral(Parser $parser): Literal
    {
        $lexer = $parser->getLexer();
        $lookaheadType = $lexer->lookahead['type'];

        switch ($lookaheadType) {
            case Lexer::T_STRING:
                return $this->matchStringLiteral($parser, $lexer);
            case Lexer::T_INTEGER:
            case Lexer::T_FLOAT:
                $parser->match(
                    $lexer->isNextToken(Lexer::T_INTEGER) ? Lexer::T_INTEGER : Lexer::T_FLOAT
                );

                return new Literal(Literal::NUMERIC, $lexer->token['value']);
            default:
                $parser->syntaxError('numeric');
        }
    }

    private function matchStringLiteral(Parser $parser, Lexer $lexer): Literal
    {
        $parser->match(Lexer::T_STRING);
        return new Literal(Literal::STRING, $lexer->token['value']);
    }


    /**
     * @param SqlWalker $sqlWalker
     * @return string
     * @throws DBALException
     * @throws \Doctrine\ORM\Query\AST\ASTException
     */
    public function getSql(SqlWalker $sqlWalker): string
    {
        $this->validatePlatform($sqlWalker);

        $args = [];
        foreach ($this->parsedArguments as $parsedArgument) {
            if ($parsedArgument === null) {
                $args[] = 'NULL';
            } else {
                $args[] = $parsedArgument->dispatch($sqlWalker);
            }
        }
        return $this->getSqlForArgs($args);
    }

    /**
     * @param string[] $arguments
     * @return string
     */
    protected function getSqlForArgs(array $arguments): string
    {
        return sprintf('%s(%s)', $this->getSQLFunction(), implode(', ', $arguments));
    }

    /**
     * @return string
     */
    protected function getSQLFunction(): string
    {
        return static::FUNCTION_NAME;
    }

    /**
     * @param SqlWalker $sqlWalker
     * @throws DBALException
     */
    abstract protected function validatePlatform(SqlWalker $sqlWalker): void;
}
