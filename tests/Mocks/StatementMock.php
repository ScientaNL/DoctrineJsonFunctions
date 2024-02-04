<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Mocks;

use Doctrine\DBAL\Driver\Result;
use Doctrine\DBAL\Driver\Statement;

class StatementMock implements Statement
{
    /**
     * {@inheritdoc}
     */
    public function bindValue($param, $value, $type = null): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function bindParam($param, &$variable, $type = null, $length = null): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function execute($params = null): Result
    {
        return new ResultMock();
    }
}
