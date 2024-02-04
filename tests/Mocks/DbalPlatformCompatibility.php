<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Mocks;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Platforms\DateIntervalUnit;
use Doctrine\DBAL\Platforms\Keywords\KeywordList;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\TableDiff;
use Doctrine\DBAL\TransactionIsolationLevel;
use ReflectionMethod;

if ((new ReflectionMethod(Driver::class, 'getDatabasePlatform'))->getNumberOfParameters() === 1) {
    // DBAL 4
    /** @internal */
    trait DbalPlatformCompatibility
    {
        public function getLocateExpression(string $string, string $substring, ?string $start = null): string
        {
            throw NotSupported::new(__METHOD__);
        }

        public function getDateDiffExpression(string $date1, string $date2): string
        {
            throw NotSupported::new(__METHOD__);
        }

        protected function getDateArithmeticIntervalExpression(string $date, string $operator, string $interval, DateIntervalUnit $unit): string
        {
            throw NotSupported::new(__METHOD__);
        }

        /**
         * @return list<string>
         */
        public function getAlterTableSQL(TableDiff $diff): array
        {
            throw NotSupported::new(__METHOD__);
        }

        public function getListViewsSQL(string $database): string
        {
            throw NotSupported::new(__METHOD__);
        }

        public function getSetTransactionIsolationSQL(TransactionIsolationLevel $level): string
        {
            throw NotSupported::new(__METHOD__);
        }

        public function getDateTimeTypeDeclarationSQL(array $column): string
        {
            throw NotSupported::new(__METHOD__);
        }

        public function getDateTypeDeclarationSQL(array $column): string
        {
            throw NotSupported::new(__METHOD__);
        }

        public function getTimeTypeDeclarationSQL(array $column): string
        {
            throw NotSupported::new(__METHOD__);
        }

        protected function createReservedKeywordsList(): KeywordList
        {
            throw NotSupported::new(__METHOD__);
        }

        public function createSchemaManager(Connection $connection): AbstractSchemaManager
        {
            throw NotSupported::new(__METHOD__);
        }
    }
} else {
    // DBAL 3
    // phpcs:ignore PSR1.Classes.ClassDeclaration.MultipleClasses
    trait DbalPlatformCompatibility
    {
    }
}
