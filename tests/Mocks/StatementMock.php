<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Mocks;

use Doctrine\DBAL\Driver\Result;
use Doctrine\DBAL\Driver\Statement;
use Override;

class StatementMock implements Statement
{
    /**
     * {@inheritdoc}
     */
    #[Override]
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
    #[Override]
    public function execute($params = null): Result
    {
        return new ResultMock();
    }
}
