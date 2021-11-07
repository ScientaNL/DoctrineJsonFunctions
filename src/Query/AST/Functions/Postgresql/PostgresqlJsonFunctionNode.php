<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\PostgreSQL94Platform;
use Doctrine\ORM\Query\SqlWalker;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\AbstractJsonFunctionNode;

abstract class PostgresqlJsonFunctionNode extends AbstractJsonFunctionNode
{
    /**
     * @param SqlWalker $sqlWalker
     * @throws Exception
     */
    protected function validatePlatform(SqlWalker$sqlWalker): void
    {
        if (!$sqlWalker->getConnection()->getDatabasePlatform() instanceof PostgreSQL94Platform) {
            throw Exception::notSupported(static::FUNCTION_NAME);
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
