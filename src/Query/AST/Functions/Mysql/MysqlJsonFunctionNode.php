<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\Query\SqlWalker;
use Scienta\DoctrineJsonFunctions\DBALCompatibility;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\AbstractJsonFunctionNode;

/**
 * @internal
 */
abstract class MysqlJsonFunctionNode extends AbstractJsonFunctionNode
{
    /**
     * @param SqlWalker $sqlWalker
     * @throws Exception
     */
    protected function validatePlatform(SqlWalker $sqlWalker): void
    {
        if (!$sqlWalker->getConnection()->getDatabasePlatform() instanceof (DBALCompatibility::mysqlDBPlatform())) {
            throw DBALCompatibility::notSupportedPlatformException(static::FUNCTION_NAME);
        }
    }
}
