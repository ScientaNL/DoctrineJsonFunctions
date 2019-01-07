<?php

namespace Scienta\DoctrineJsonFunctions\Query\AST\Functions;

abstract class AbstractJsonOperatorFunctionNode extends AbstractJsonFunctionNode
{
    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_PRIMARY_ARG, self::STRING_PRIMARY_ARG];

    abstract public function getOperator(): string;

    /**
     * @param string[] $arguments
     * @return string
     */
    protected function getSqlForArgs(array $arguments): string
    {
        [$leftArg, $rightArg] = $arguments;
        return sprintf('%s %s %s', $leftArg, $this->getOperator(), $rightArg);
    }
}
