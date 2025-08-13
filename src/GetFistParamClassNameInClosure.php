<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder;

use Closure;
use ReflectionException;
use ReflectionFunction;

final readonly class GetFistParamClassNameInClosure
{
    /**
     * @throws ReflectionException
     */
    public function execute(
        Closure $callback,
    ): ?string {
        $reflection = new ReflectionFunction($callback);

        if ($reflection->getNumberOfParameters() !== 1) {
            return null;
        }

        $firstParam = $reflection->getParameters()[0];

        return $firstParam
            ->getType()
            ->getName();
    }
}
