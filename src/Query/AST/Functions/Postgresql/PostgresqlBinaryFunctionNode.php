<?php


namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;


use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

abstract class PostgresqlBinaryFunctionNode extends FunctionNode
{
    /** @var \Doctrine\ORM\Query\AST\Node */
    protected $jsonData;

    /** @var \Doctrine\ORM\Query\AST\Node */
    protected $jsonPath;


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


    /**
     * @param SqlWalker $sqlWalker
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        $jsonData = $sqlWalker->walkStringPrimary($this->jsonData);
        $jsonPath = $this->jsonPath->dispatch($sqlWalker);

        // TODO test for PostgreSQL 9.3  (not until Doctrine\DBAL v2.6)

        /** @noinspection PhpUndefinedClassConstantInspection */
        return $jsonData . static::OPERATOR . $jsonPath;
    }
}
