<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Mocks;

use Doctrine\DBAL\Driver\Result;
use Override;

class ResultMock implements Result
{
    #[Override]
    public function fetchNumeric(): array|false
    {
        return false;
    }

    #[Override]
    public function fetchAssociative(): array|false
    {
        return false;
    }

    #[Override]
    public function fetchOne(): bool
    {
        return false;
    }

    #[Override]
    public function fetchAllNumeric(): array
    {
        return [];
    }

    #[Override]
    public function fetchAllAssociative(): array
    {
        return [];
    }

    #[Override]
    public function fetchFirstColumn(): array
    {
        return [];
    }

    #[Override]
    public function rowCount(): int
    {
        return 0;
    }

    #[Override]
    public function columnCount(): int
    {
        return 0;
    }

    #[Override]
    public function free(): void
    {
    }
}
