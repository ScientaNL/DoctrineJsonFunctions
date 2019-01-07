<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\ORM\Query\SqlWalker;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\AbstractJsonOperatorFunctionNode;

abstract class PostgresqlJsonOperatorFunctionNode extends AbstractJsonOperatorFunctionNode
{
    public const OPERATOR = null;

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
    public function getOperator(): string
    {
        return static::OPERATOR;
    }
}
