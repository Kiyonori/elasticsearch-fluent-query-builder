<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

use Closure;
use Kiyonori\ElasticsearchFluentQueryBuilder\Contracts\Arrayable;
use Kiyonori\ElasticsearchFluentQueryBuilder\GetFistParamClassNameInClosure;
use ReflectionException;

final class Query implements Arrayable
{
    private array $bool = [];

    /**
     * @throws ReflectionException
     */
    public function bool(
        Closure $callback,
    ): self {
        /** @var ?string $classFqn */
        $classFqn = app(GetFistParamClassNameInClosure::class)
            ->execute($callback);

        if ($classFqn === null) {
            return $this;
        }

        /** @var Arrayable $instance */
        $instance = app($classFqn);

        $isArrayable = $instance instanceof Arrayable;

        if ($isArrayable === false) {
            return $this;
        }

        $callback($instance);

        $this->bool = $instance->toArray();

        return $this;
    }

    public function toArray(): array
    {
        return [
            'query' => [
                'bool' => $this->bool,
            ],
        ];
    }
}
