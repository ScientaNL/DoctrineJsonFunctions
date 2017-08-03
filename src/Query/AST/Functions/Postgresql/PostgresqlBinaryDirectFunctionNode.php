<?php


namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;


abstract class PostgresqlBinaryDirectFunctionNode extends PostgresqlBinaryFunctionNode
{
    protected function getSqlForParams($left, $right)
    {
        // PDO breaks when operators that contain '?' are used.
        // For example when applied to JSON value, ? operator checks if left
        // operand contains right operand as a key or field, like this:
        //   SELECT * FROM foo WHERE contents?'bar'
        // However PDO interprets it as a query parameter and fails, possibly
        // producing a nonsensical error message (eg. "schema does not exist").
        // Luckily, all Postgres operators have equivalent functions that can
        // be found like this:
        //   SELECT oprname, oprcode FROM pg_operator WHERE oprname IN ('?', '?|', '?&')
        // These don't contain '?' and can be used safely.
        // Credits: https://stackoverflow.com/a/16312053/1937994
        /** @noinspection PhpUndefinedClassConstantInspection */
        return static::DIRECT_FUNCTION . "($left, $right)";
    }
}
