<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Mocks;

use Doctrine\DBAL\Result;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Doctrine\DBAL\Schema\View;
use Doctrine\DBAL\Types\Type;
use Scienta\DoctrineJsonFunctions\Tests\Mocks\Exception\NotImplemented;

/**
 * Mock class for AbstractSchemaManager.
 *
 * @extends AbstractSchemaManager<DatabasePlatformMock>
 */
class SchemaManagerMock extends AbstractSchemaManager
{
    /**
     * @param Connection $conn
     */
    public function __construct(Connection $conn)
    {
        parent::__construct($conn, new DatabasePlatformMock());
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableTableColumnDefinition($tableColumn): Column
    {
        return new Column('portable', Type::getType('string'));
    }

    protected function selectTableNames(string $databaseName): Result
    {
        throw new NotImplemented(__METHOD__);
    }

    protected function selectTableColumns(string $databaseName, ?string $tableName = null): Result
    {
        throw new NotImplemented(__METHOD__);
    }

    protected function selectIndexColumns(string $databaseName, ?string $tableName = null): Result
    {
        throw new NotImplemented(__METHOD__);
    }

    protected function selectForeignKeyColumns(string $databaseName, ?string $tableName = null): Result
    {
        throw new NotImplemented(__METHOD__);
    }

    protected function fetchTableOptionsByTable(string $databaseName, ?string $tableName = null): array
    {
        throw new NotImplemented(__METHOD__);
    }

    protected function _getPortableTableDefinition(array $table): string
    {
        throw new NotImplemented(__METHOD__);
    }

    protected function _getPortableViewDefinition(array $view): View
    {
        throw new NotImplemented(__METHOD__);
    }

    protected function _getPortableTableForeignKeyDefinition(array $tableForeignKey): ForeignKeyConstraint
    {
        throw new NotImplemented(__METHOD__);
    }
}
