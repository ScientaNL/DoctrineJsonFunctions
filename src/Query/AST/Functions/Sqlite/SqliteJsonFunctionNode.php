<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions\Sqlite;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\Query\SqlWalker;
use Scienta\DoctrineJsonFunctions\DBALCompatibility;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\AbstractJsonFunctionNode;
use Override;

/**
 * @internal
 */
abstract class SqliteJsonFunctionNode extends AbstractJsonFunctionNode
{
    /**
     * @param SqlWalker $sqlWalker
     * @throws Exception
     */
    #[Override]
    protected function validatePlatform(SqlWalker $sqlWalker): void
    {
        if (!$sqlWalker->getConnection()->getDatabasePlatform() instanceof (DBALCompatibility::sqlLitePlatform())) {
            throw DBALCompatibility::notSupportedPlatformException(static::FUNCTION_NAME);
        }
    }
}
