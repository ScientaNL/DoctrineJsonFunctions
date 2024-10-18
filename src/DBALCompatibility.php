<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions;

use Doctrine\DBAL\Exception as DBALException;
use Exception;

use function class_exists;
use function method_exists;

/**
 * @internal
 */
final class DBALCompatibility
{
    public static function notSupportedPlatformException(string $method): Exception
    {
        // phpcs:disable SlevomatCodingStandard.Namespaces.ReferenceUsedNamesOnly.ReferenceViaFullyQualifiedName
        if (class_exists('Doctrine\DBAL\Platforms\Exception\NotSupported')) {
            return \Doctrine\DBAL\Platforms\Exception\NotSupported::new($method);
        }

        /**
         * @psalm-suppress UndefinedClass
         */
        if (method_exists(DBALException::class, 'notSupported')) {
            return DBALException::notSupported($method);
        }

        return new Exception("Method $method is not supported for doctrine platform");
    }

    public static function sqlLitePlatform(): string
    {
        if (class_exists('Doctrine\DBAL\Platforms\SQLitePlatform')) {
            return 'Doctrine\DBAL\Platforms\SQLitePlatform';
        }

        return 'Doctrine\DBAL\Platforms\SqlitePlatform';
    }

    public static function mariaDBPlatform(): string
    {
        if (!class_exists('\Doctrine\DBAL\Platforms\MariaDBPlatform')) {
            // In DBAL versions prior to 3.3, MariaDB used or extended the MySQL platform
            return '\Doctrine\DBAL\Platforms\MySQLPlatform';
        }

        // DBAL 3.3 and onwards
        return '\Doctrine\DBAL\Platforms\MariaDBPlatform';
    }

    public static function mysqlAndMariaDBSharedPlatform(): string
    {
        if (!class_exists('\Doctrine\DBAL\Platforms\AbstractMySQLPlatform')) {
            // In DBAL versions prior to 3.3, MariaDB used or extended the MySQL platform
            return '\Doctrine\DBAL\Platforms\MySQLPlatform';
        }

        // DBAL 3.3 and onwards
        return '\Doctrine\DBAL\Platforms\AbstractMySQLPlatform';
    }
}
