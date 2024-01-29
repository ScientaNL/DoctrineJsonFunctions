<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Mocks;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Mock class for DatabasePlatform.
 */
class DatabasePlatformMock extends AbstractPlatform
{
    /**
     * @var string
     */
    private $_sequenceNextValSql = "";

    /**
     * @var bool
     */
    private $_prefersIdentityColumns = true;

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
    public function getSequenceNextValSQL($sequence): string
    {
        return $this->_sequenceNextValSql;
    }

    /**
     * {@inheritdoc}
     */
    public function getBooleanTypeDeclarationSQL(array $column): string
    {
        return 'TINYINT(1)';
    }

    /**
     * {@inheritdoc}
     */
    public function getIntegerTypeDeclarationSQL(array $column): string
    {
        return 'INT' . $this->_getCommonIntegerTypeDeclarationSQL($column);
    }

    /**
     * {@inheritdoc}
     */
    public function getBigIntTypeDeclarationSQL(array $column): string
    {
        return 'BIGINT' . $this->_getCommonIntegerTypeDeclarationSQL($column);
    }

    /**
     * {@inheritdoc}
     */
    public function getSmallIntTypeDeclarationSQL(array $column): string
    {
        return 'SMALLINT' . $this->_getCommonIntegerTypeDeclarationSQL($column);
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    protected function initializeDoctrineTypeMappings()
    {
    }

    /**
     * @param array $column
     * @return string
     * @throws Exception
     */
    public function getBlobTypeDeclarationSQL(array $column): string
    {
        throw Exception::notSupported(__METHOD__);
    }

    /**
     * @throws Exception
     */
    public function getCurrentDatabaseExpression(): string
    {
        throw Exception::notSupported(__METHOD__);
    }
}
