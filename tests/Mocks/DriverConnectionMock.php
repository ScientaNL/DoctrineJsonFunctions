<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Mocks;

use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Driver\Result;
use Doctrine\DBAL\Driver\Statement;
use PDO;
use Scienta\DoctrineJsonFunctions\Tests\Mocks\Exception\NotImplemented;

/**
 * Mock class for DriverConnection.
 * @psalm-suppress MethodSignatureMismatch
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
    public function quote($value, $type = PDO::PARAM_STR): string
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
    public function lastInsertId($name = null): int|string
    {
        return 0;
    }

    public function beginTransaction(): void
    {
    }

    public function commit(): void
    {
    }

    public function rollBack(): void
    {
    }

    public function errorCode()
    {
    }

    public function errorInfo()
    {
    }

    public function getNativeConnection()
    {
        throw new NotImplemented(__METHOD__);
    }

    public function getServerVersion(): string
    {
        throw new NotImplemented(__METHOD__);
    }
}
