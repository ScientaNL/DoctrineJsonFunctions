<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Scienta\DoctrineJsonFunctions\Tests\DoctrineJsonTestcase;
use Scienta\DoctrineJsonFunctions\Tests\Mocks;

abstract class DbTestCase extends DoctrineJsonTestcase
{
    /** @var EntityManager */
    public $entityManager;

    /** @var Configuration */
    protected $configuration;

    /**
     * @throws \Doctrine\ORM\ORMException
     */
    public function setUp()
    {
        $this->configuration = new Configuration();
        $this->configuration->setMetadataCacheImpl(new ArrayCache());
        $this->configuration->setQueryCacheImpl(new ArrayCache());
        $this->configuration->setProxyDir(__DIR__ . '/Proxies');
        $this->configuration->setProxyNamespace('DoctrineExtensions\Tests\Proxies');
        $this->configuration->setAutoGenerateProxyClasses(true);
        $this->configuration->setMetadataDriverImpl($this->configuration->newDefaultAnnotationDriver([]));

        $conn = [
            'driverClass'  => Mocks\DriverMock::class,
            'wrapperClass' => Mocks\ConnectionMock::class,
            'user'         => 'john',
            'password'     => 'wayne'
        ];

        $this->entityManager = EntityManager::create($conn, $this->configuration);
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
     */
    protected function produceSql(string $dql, array $params = []): string
    {
        $q = $this->entityManager->createQuery($dql);
        foreach ($params as $key => $value) {
            $q->setParameter($key, $value);
        }
        return $q->getSql();
    }
}
