<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\ORM\Query\SqlWalker;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\AbstractJsonOperatorFunctionNode;

abstract class PostgresqlJsonOperatorFunctionNode extends AbstractJsonOperatorFunctionNode
{
    public const OPERATOR = null;

    /**
     * @param SqlWalker $sqlWalker
     * @throws Exception
     */
    protected function validatePlatform(SqlWalker $sqlWalker): void
    {
        if (!$sqlWalker->getConnection()->getDatabasePlatform() instanceof PostgreSQLPlatform) {
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
