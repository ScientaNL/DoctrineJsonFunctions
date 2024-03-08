<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Scienta\DoctrineJsonFunctions\Tests\DoctrineJsonTestcase;
use Scienta\DoctrineJsonFunctions\Tests\Mocks;
use Webmozart\Assert\Assert;

abstract class DbTestCase extends DoctrineJsonTestcase
{
    /** @var EntityManager */
    public $entityManager;

    /** @var Configuration */
    protected $configuration;

    public function setUp(): void
    {
        $this->configuration = ORMSetup::createAttributeMetadataConfiguration([], true, __DIR__ . '/Proxies');

        $conn = DriverManager::getConnection([
            'driverClass'  => Mocks\DriverMock::class,
            'wrapperClass' => Mocks\ConnectionMock::class,
            'user'         => 'john',
            'password'     => 'wayne'
        ], $this->configuration);

        $this->entityManager = new EntityManager($conn, $this->configuration);
    }

    /**
     * @param string $actualDql
     * @param string $expectedSql
     * @param array $params
     */
    protected function assertDqlProducesSql(string $actualDql, string $expectedSql, array $params = [])
    {
        $this->assertEquals($expectedSql, $this->produceSql($actualDql, $params));
    }

    /**
     * @param string $dql
     * @param array $params
     * @return string
     */
    protected function produceSql(string $dql, array $params = []): string
    {
        $q = $this->entityManager->createQuery($dql);
        foreach ($params as $key => $value) {
            $q->setParameter($key, $value);
        }
        $result = $q->getSql();
        Assert::string($result);
        return $result;
    }
}
