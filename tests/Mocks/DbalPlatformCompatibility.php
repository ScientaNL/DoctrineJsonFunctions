<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Mocks;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\DateIntervalUnit;
use Doctrine\DBAL\Platforms\Keywords\KeywordList;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\TableDiff;
use Doctrine\DBAL\TransactionIsolationLevel;
use ReflectionMethod;
use Scienta\DoctrineJsonFunctions\DBALCompatibility;

if ((new ReflectionMethod(AbstractPlatform::class, 'getLocateExpression'))->isAbstract()) {
    // DBAL 4
    /** @internal */
    trait DbalPlatformCompatibility
    {
        public function getLocateExpression(string $string, string $substring, ?string $start = null): string
        {
            throw DBALCompatibility::notSupportedPlatformException(__METHOD__);
        }

        public function getDateDiffExpression(string $date1, string $date2): string
        {
            throw DBALCompatibility::notSupportedPlatformException(__METHOD__);
        }

        protected function getDateArithmeticIntervalExpression(string $date, string $operator, string $interval, DateIntervalUnit $unit): string
        {
            throw DBALCompatibility::notSupportedPlatformException(__METHOD__);
        }

        /**
         * @return list<string>
         */
        public function getAlterTableSQL(TableDiff $diff): array
        {
            throw DBALCompatibility::notSupportedPlatformException(__METHOD__);
        }

        public function getListViewsSQL(string $database): string
        {
            throw DBALCompatibility::notSupportedPlatformException(__METHOD__);
        }

        public function getSetTransactionIsolationSQL(TransactionIsolationLevel $level): string
        {
            throw DBALCompatibility::notSupportedPlatformException(__METHOD__);
        }

        public function getDateTimeTypeDeclarationSQL(array $column): string
        {
            throw DBALCompatibility::notSupportedPlatformException(__METHOD__);
        }

        public function getDateTypeDeclarationSQL(array $column): string
        {
            throw DBALCompatibility::notSupportedPlatformException(__METHOD__);
        }

        public function getTimeTypeDeclarationSQL(array $column): string
        {
            throw DBALCompatibility::notSupportedPlatformException(__METHOD__);
        }

        protected function createReservedKeywordsList(): KeywordList
        {
            throw DBALCompatibility::notSupportedPlatformException(__METHOD__);
        }

        public function createSchemaManager(Connection $connection): AbstractSchemaManager
        {
            throw DBALCompatibility::notSupportedPlatformException(__METHOD__);
        }
    }
} else {
    // DBAL 3
    // phpcs:ignore PSR1.Classes.ClassDeclaration.MultipleClasses
    trait DbalPlatformCompatibility
    {
    }
}
