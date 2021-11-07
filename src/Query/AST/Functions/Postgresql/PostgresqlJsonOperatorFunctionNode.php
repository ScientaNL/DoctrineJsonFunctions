<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\PostgreSQL94Platform;
use Doctrine\ORM\Query\SqlWalker;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\AbstractJsonOperatorFunctionNode;

abstract class PostgresqlJsonOperatorFunctionNode extends AbstractJsonOperatorFunctionNode
{
    public const OPERATOR = null;

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
    public function getOperator(): string
    {
        return static::OPERATOR;
    }
}
