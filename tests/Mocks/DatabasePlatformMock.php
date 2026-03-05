<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Mocks;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Scienta\DoctrineJsonFunctions\Tests\Mocks\Exception\NotImplemented;
use Override;

/**
 * Mock class for DatabasePlatform.
 */
class DatabasePlatformMock extends AbstractPlatform
{
    use DbalPlatformCompatibility;

    /**
     * @var string
     */
    private $_sequenceNextValSql = "";

    /**
     * @var bool
     */
    private $_prefersIdentityColumns = true;

    #[Override]
    public function supportsIdentityColumns(): bool
    {
        return true;
    }

    public function prefersIdentityColumns(): bool
    {
        return $this->_prefersIdentityColumns;
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function getSequenceNextValSQL($sequence): string
    {
        return $this->_sequenceNextValSql;
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function getBooleanTypeDeclarationSQL(array $column): string
    {
        return 'TINYINT(1)';
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function getIntegerTypeDeclarationSQL(array $column): string
    {
        return 'INT' . $this->_getCommonIntegerTypeDeclarationSQL($column);
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function getBigIntTypeDeclarationSQL(array $column): string
    {
        return 'BIGINT' . $this->_getCommonIntegerTypeDeclarationSQL($column);
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function getSmallIntTypeDeclarationSQL(array $column): string
    {
        return 'SMALLINT' . $this->_getCommonIntegerTypeDeclarationSQL($column);
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    protected function _getCommonIntegerTypeDeclarationSQL(array $column): string
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getVarcharTypeDeclarationSQL(array $column): string
    {
        return 'VARCHAR(255)';
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function getClobTypeDeclarationSQL(array $column): string
    {
        return 'LONGTEXT';
    }

    /* MOCK API */

    /**
     * @param bool $bool
     *
     * @return void
     */
    public function setPrefersIdentityColumns(bool $bool)
    {
        $this->_prefersIdentityColumns = $bool;
    }

    /**
     * @param string $sql
     *
     * @return void
     */
    public function setSequenceNextValSql(string $sql)
    {
        $this->_sequenceNextValSql = $sql;
    }

    public function getName(): string
    {
        return 'mock';
    }

    #[Override]
    protected function initializeDoctrineTypeMappings(): void
    {
    }

    /**
     * @param array $column
     * @return string
     * @throws Exception
     */
    #[Override]
    public function getBlobTypeDeclarationSQL(array $column): string
    {
        throw new NotImplemented(__METHOD__);
    }

    /**
     * @throws Exception
     */
    #[Override]
    public function getCurrentDatabaseExpression(): string
    {
        throw new NotImplemented(__METHOD__);
    }
}
