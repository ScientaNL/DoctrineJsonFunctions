<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Mocks;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Result;
use Exception;
use Webmozart\Assert\Assert;

/**
 * Mock class for Connection.
 */
class ConnectionMock extends Connection
{
    /**
     * @var mixed
     */
    private $_fetchOneResult;

    /**
     * @var Exception|null
     */
    private $_fetchOneException;

    /**
     * @var Result|null
     */
    private $_queryResult = null;

    /**
     * @var DatabasePlatformMock
     */
    private $_platformMock;

    /**
     * @var int
     */
    private $_lastInsertId = 0;

    /**
     * @var array
     */
    private $_inserts = [];

    /**
     * @var array
     */
    private $_executeUpdates = [];

    /**
     * @var DatabasePlatformMock
     */
    private $_platform;

    /**
     * @psalm-suppress InternalMethod
     * @param array                              $params
     * @param Driver              $driver
     * @param Configuration|null  $config
     * @param EventManager|null $eventManager
     * @throws \Doctrine\DBAL\Exception
     */
    public function __construct(array $params, $driver, $config = null, $eventManager = null)
    {
        $this->_platformMock = new DatabasePlatformMock();

        parent::__construct($params, $driver, $config, $eventManager);

        // Override possible assignment of platform to database platform mock
        $this->_platform = $this->_platformMock;
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabasePlatform()
    {
        return $this->_platformMock;
    }

    /**
     * {@inheritdoc}
     */
    public function insert($table, array $data, array $types = [])
    {
        $this->_inserts[$table][] = $data;

        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public function executeUpdate($sql, array $params = [], array $types = []): int
    {
        $this->_executeUpdates[] = ['query' => $sql, 'params' => $params, 'types' => $types];

        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public function lastInsertId($name = null)
    {
        return $this->_lastInsertId;
    }

    /**
     * @throws Exception
     */
    public function fetchColumn($statement, array $params = [], $colnum = 0, array $types = [])
    {
        if ($this->_fetchOneException !== null) {
            throw $this->_fetchOneException;
        }

        return $this->_fetchOneResult;
    }

    public function query(string $sql): Result
    {
        $result = $this->_queryResult;
        Assert::notNull($result);
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function quote($value, $type = null)
    {
        if (is_string($value)) {
            return "'" . $value . "'";
        }
        return $value;
    }

    /* Mock API */

    /**
     * @param mixed $fetchOneResult
     *
     * @return void
     */
    public function setFetchOneResult($fetchOneResult)
    {
        $this->_fetchOneResult = $fetchOneResult;
    }

    /**
     * @param Exception|null $exception
     *
     * @return void
     */
    public function setFetchOneException(?Exception $exception = null)
    {
        $this->_fetchOneException = $exception;
    }

    /**
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     *
     * @return void
     */
    public function setDatabasePlatform($platform)
    {
        $this->_platformMock = $platform;
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function setLastInsertId($id)
    {
        $this->_lastInsertId = $id;
    }

    /**
     * @param Result $result
     */
    public function setQueryResult(Result $result)
    {
        $this->_queryResult = $result;
    }

    /**
     * @return array
     */
    public function getInserts()
    {
        return $this->_inserts;
    }

    /**
     * @return array
     */
    public function getExecuteUpdates()
    {
        return $this->_executeUpdates;
    }

    /**
     * @return void
     */
    public function reset()
    {
        $this->_inserts = [];
        $this->_lastInsertId = 0;
    }
}
