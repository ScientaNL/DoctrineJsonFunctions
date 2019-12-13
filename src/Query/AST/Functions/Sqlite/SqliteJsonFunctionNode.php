<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Sqlite;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\SqlitePlatform;
use Doctrine\ORM\Query\SqlWalker;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\AbstractJsonFunctionNode;

abstract class SqliteJsonFunctionNode extends AbstractJsonFunctionNode
{
    /**
     * @param SqlWalker $sqlWalker
     * @throws DBALException
     */
    protected function validatePlatform(SqlWalker$sqlWalker): void
    {
        if (!$sqlWalker->getConnection()->getDatabasePlatform() instanceof SqlitePlatform) {
            throw DBALException::notSupported(static::FUNCTION_NAME);
        }
    }
}
