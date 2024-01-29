<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Mocks;

use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;

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
}
