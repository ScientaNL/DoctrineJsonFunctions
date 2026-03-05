<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;
use Override;

abstract class IntegrationTestCase extends TestCase
{
    protected ?EntityManager $entityManager = null;

    /**
     * Return the DBAL connection URL for this platform, or null to skip all tests.
     * e.g. "mysql://root:root@127.0.0.1:3306/doctrine_json_test"
     */
    abstract protected static function getConnectionUrl(): ?string;

    abstract protected static function loadDqlFunctions(Configuration $config): void;

    #[Override]
    protected function setUp(): void
    {
        $url = static::getConnectionUrl();
        if ($url === null) {
            $this->markTestSkipped('No DB connection configured for this platform.');
        }

        $config = ORMSetup::createAttributeMetadataConfiguration(
            [__DIR__ . '/../Entities'],
            true
        );

        if (PHP_VERSION_ID >= 80400) {
            $config->enableNativeLazyObjects(true);
        }

        static::loadDqlFunctions($config);

        $dsnParser = new DsnParser([
            'mysql'      => 'pdo_mysql',
            'mysql2'     => 'pdo_mysql',
            'mariadb'    => 'pdo_mysql',
            'postgres'   => 'pdo_pgsql',
            'postgresql' => 'pdo_pgsql',
            'pgsql'      => 'pdo_pgsql',
            'sqlite'     => 'pdo_sqlite',
            'sqlite3'    => 'pdo_sqlite',
        ]);
        $conn = DriverManager::getConnection($dsnParser->parse($url));
        $this->entityManager = new EntityManager($conn, $config);

        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);

        // Insert one blank row so scalar-select tests (FROM Blank b) always have a row.
        $this->entityManager->getConnection()->insert('Blank', ['id' => 'seed']);
    }

    #[Override]
    protected function tearDown(): void
    {
        if ($this->entityManager === null) {
            return;
        }
        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->dropSchema($metadata);
        $this->entityManager->close();
    }

    /**
     * Insert a row into the JsonData table directly via DBAL, bypassing ORM type
     * encoding to avoid platform-specific JSON type differences.
     *
     * @param mixed $jsonCol  Value to JSON-encode into the jsonCol column
     * @param mixed $jsonData Value to JSON-encode into the jsonData column
     */
    protected function insertJsonData(mixed $jsonCol, mixed $jsonData): void
    {
        $encoded = json_encode($jsonCol);
        $encodedData = json_encode($jsonData);

        $this->entityManager->getConnection()->insert('JsonData', [
            'id'       => uniqid('', true),
            'jsonCol'  => $encoded !== false ? $encoded : '{}',
            'jsonData' => $encodedData !== false ? $encodedData : '{}',
        ]);
    }
}
