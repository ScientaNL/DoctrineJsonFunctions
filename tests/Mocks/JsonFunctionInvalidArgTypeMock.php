<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Mocks;

use Doctrine\ORM\Query\SqlWalker;
use Override;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\AbstractJsonFunctionNode;

class JsonFunctionInvalidArgTypeMock extends AbstractJsonFunctionNode
{
    public const FUNCTION_NAME = 'JSON_MOCK_INVALID';

    /** @var string[] */
    protected $requiredArgumentTypes = ['__invalid_type__'];

    #[Override]
    protected function validatePlatform(SqlWalker $sqlWalker): void
    {
    }
}
