<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Mocks;

use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Driver\Result;
use Doctrine\DBAL\Driver\Statement;
use PDO;

/**
 * Mock class for DriverConnection.
 */
class DriverConnectionMock implements Connection
{
    /**
     * @var Statement
     */
    private $statementMock;

    /**
     * @return Statement
     */
    public function getStatementMock(): Statement
    {
        return $this->statementMock;
    }

    /**
     * @param Statement $statementMock
     */
    public function setStatementMock(Statement $statementMock)
    {
        $this->statementMock = $statementMock;
    }

    /**
     * {@inheritdoc}
     */
    public function prepare($sql): Statement
    {
        return $this->statementMock ?: new StatementMock();
    }

    /**
     * {@inheritdoc}
     * @param string $sql
     */
    public function query(string $sql): Result
    {
        return new ResultMock();
    }

    /**
     * {@inheritdoc}
     */
    public function quote($value, $type = PDO::PARAM_STR)
    {
        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function exec($sql): int
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public function lastInsertId($name = null)
    {
        return 0;
    }

    public function beginTransaction(): bool
    {
        return true;
    }

    public function commit(): bool
    {
        return true;
    }

    public function rollBack(): bool
    {
        return true;
    }

    public function errorCode()
    {
    }

    public function errorInfo()
    {
    }
}
