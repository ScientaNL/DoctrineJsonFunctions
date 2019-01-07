<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\ORM\Query\SqlWalker;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\AbstractJsonFunctionNode;

abstract class PostgresqlJsonFunctionNode extends AbstractJsonFunctionNode
{
    /**
     * @param SqlWalker $sqlWalker
     * @throws DBALException
     */
    protected function validatePlatform(SqlWalker$sqlWalker): void
    {
        if (!$sqlWalker->getConnection()->getDatabasePlatform() instanceof PostgreSqlPlatform) {
            throw DBALException::notSupported(static::FUNCTION_NAME);
        }
    }

    /**
     * @return string
     */
    protected function getSQLFunction(): string
    {
        return strtolower(static::FUNCTION_NAME);
    }
}
