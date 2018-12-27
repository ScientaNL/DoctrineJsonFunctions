<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

abstract class AbstractJsonFunctionNode extends FunctionNode
{
    public const FUNCTION_NAME = null;

    /** @var int */
    protected $requiredArgumentCount = 1;

    /** @var int */
    protected $optionalArgumentCount = 0;

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

        for ($i = 0; $i < $this->requiredArgumentCount; $i++) {
            if ($i > 0) {
                $parser->match(Lexer::T_COMMA);
            }
            $this->parsedArguments[] = $parser->StringPrimary();
        }

        if ($this->optionalArgumentCount > 0) {
            $this->parseOptionalArguments($parser, $this->requiredArgumentCount < 1);
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * @param Parser $parser
     * @param bool $argumentsParsed
     * @throws \Doctrine\ORM\Query\QueryException
     */
    protected function parseOptionalArguments(Parser $parser, bool $argumentsParsed): void
    {
        $isFirstArg = false;
        if ($argumentsParsed) {
            $continueParsing = !$parser->getLexer()->isNextToken(Lexer::T_CLOSE_PARENTHESIS);
            $isFirstArg = true;
        } else {
            $continueParsing = $parser->getLexer()->isNextToken(Lexer::T_COMMA);
        }
        while ($continueParsing) {
            for ($i = 0; $i < $this->optionalArgumentCount; $i++) {
                if (!$isFirstArg) {
                    $parser->match(Lexer::T_COMMA);
                } else {
                    $isFirstArg = false;
                }
                $this->parsedArguments[] = $parser->StringPrimary();
            }
            $continueParsing = $this->allowOptionalArgumentRepeat && $parser->getLexer()->isNextToken(Lexer::T_COMMA);
        }
    }

    /**
     * @param SqlWalker $sqlWalker
     * @return string
     * @throws DBALException
     */
    public function getSql(SqlWalker $sqlWalker): string
    {
        $this->validatePlatform($sqlWalker);

        $args = [];
        foreach ($this->parsedArguments as $argumentString) {
            $args[] = $sqlWalker->walkStringPrimary($argumentString);
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
