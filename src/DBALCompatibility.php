<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions;

use Doctrine\DBAL\Exception as DBALException;
use Doctrine\DBAL\Platforms\Exception\NotSupported;
use Exception;

use function class_exists;

/**
 * @internal
 */
final class DBALCompatibility
{
    public static function notSupportedPlatformException(string $method): Exception
    {
        if (class_exists('Doctrine\DBAL\Platforms\Exception\NotSupported')) {
            return NotSupported::new($method);
        }

        /**
         * @psalm-suppress UndefinedClass
         */
        return DBALException::notSupported($method);
    }

    public static function sqlLitePlatform(): string
    {
        if (class_exists('Doctrine\DBAL\Platforms\SQLitePlatform')) {
            return 'Doctrine\DBAL\Platforms\SQLitePlatform';
        }

        return 'Doctrine\DBAL\Platforms\SqlitePlatform';
    }
}
