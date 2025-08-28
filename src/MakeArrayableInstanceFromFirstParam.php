<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder;

use Closure;
use Kiyonori\ElasticsearchFluentQueryBuilder\Contracts\Arrayable;
use ReflectionException;
use ReflectionFunction;

final readonly class MakeArrayableInstanceFromFirstParam
{
    /**
     * @throws ReflectionException
     */
    public function execute(
        ?Closure $callback = null,
    ): ?Arrayable {
        if ($callback === null) {
            return null;
        }

        $reflection = new ReflectionFunction($callback);

        if ($reflection->getNumberOfParameters() !== 1) {
            return null;
        }

        $firstParam = $reflection->getParameters()[0];

        $classFqn = $firstParam
            ->getType()
            ->getName();

        /** @var Arrayable|object $instance */
        $instance = app($classFqn);

        if (($instance instanceof Arrayable) === false) {
            return null;
        }

        return $instance;
    }
}
