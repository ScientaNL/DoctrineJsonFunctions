<?php

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

    /**
     * {@inheritdoc}
     */
    public function supportsIdentityColumns() {
        return true;
    }


    /**
     * {@inheritdoc}
     */
    public function prefersIdentityColumns()
    {
        return $this->_prefersIdentityColumns;
    }

    /**
     * {@inheritdoc}
     */
    public function getSequenceNextValSQL($sequenceName)
    {
        return $this->_sequenceNextValSql;
    }

    /**
     * {@inheritdoc}
     */
    public function getBooleanTypeDeclarationSQL(array $field)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getIntegerTypeDeclarationSQL(array $field)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getBigIntTypeDeclarationSQL(array $field)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getSmallIntTypeDeclarationSQL(array $field)
    {
    }

    /**
     * {@inheritdoc}
     */
    protected function _getCommonIntegerTypeDeclarationSQL(array $columnDef)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getVarcharTypeDeclarationSQL(array $field)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getClobTypeDeclarationSQL(array $field)
    {
    }

    /* MOCK API */

    /**
     * @param bool $bool
     *
     * @return void
     */
    public function setPrefersIdentityColumns($bool)
    {
        $this->_prefersIdentityColumns = $bool;
    }

    /**
     * @param string $sql
     *
     * @return void
     */
    public function setSequenceNextValSql($sql)
    {
        $this->_sequenceNextValSql = $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
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
     * @param array $field
     * @return string|void
     * @throws Exception
     */
    public function getBlobTypeDeclarationSQL(array $field)
    {
        throw Exception::notSupported(__METHOD__);
    }

    public function getCurrentDatabaseExpression(): string {
        throw Exception::notSupported(__METHOD__);
    }
}
