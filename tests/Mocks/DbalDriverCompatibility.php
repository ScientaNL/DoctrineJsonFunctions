<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Mocks;

use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\ServerVersionProvider;
use ReflectionMethod;

if ((new ReflectionMethod(Driver::class, 'getDatabasePlatform'))->getNumberOfParameters() === 1) {
    // DBAL 4
    /** @internal */
    trait DbalDriverCompatibility
    {
        /**
         * @psalm-suppress UndefinedClass
         */
        public function getDatabasePlatform(ServerVersionProvider $versionProvider): AbstractPlatform
        {
            if (! $this->_platformMock) {
                $this->_platformMock = new DatabasePlatformMock();
            }
            return $this->_platformMock;
        }
    }
} else {
    // DBAL 3
    // phpcs:ignore PSR1.Classes.ClassDeclaration.MultipleClasses
    trait DbalDriverCompatibility
    {
        public function getDatabasePlatform(): AbstractPlatform
        {
            if (!$this->_platformMock) {
                $this->_platformMock = new DatabasePlatformMock();
            }
            return $this->_platformMock;
        }
    }
}
