<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Mocks;

use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Driver\Result;
use Doctrine\DBAL\Driver\Statement;
use PDO;
use Scienta\DoctrineJsonFunctions\Tests\Mocks\Exception\NotImplemented;
use Override;

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
    #[Override]
    public function prepare($sql): Statement
    {
        return $this->statementMock ?: new StatementMock();
    }

    /**
     * {@inheritdoc}
     * @param string $sql
     */
    #[Override]
    public function query(string $sql): Result
    {
        return new ResultMock();
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function quote($value, $type = PDO::PARAM_STR): string
    {
        return $value;
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function exec($sql): int
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function lastInsertId($name = null): int|string
    {
        return 0;
    }

    #[Override]
    public function beginTransaction(): void
    {
    }

    #[Override]
    public function commit(): void
    {
    }

    #[Override]
    public function rollBack(): void
    {
    }

    public function errorCode()
    {
    }

    public function errorInfo()
    {
    }

    #[Override]
    public function getNativeConnection()
    {
        throw new NotImplemented(__METHOD__);
    }

    #[Override]
    public function getServerVersion(): string
    {
        throw new NotImplemented(__METHOD__);
    }
}
