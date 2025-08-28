<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

use Closure;
use Kiyonori\ElasticsearchFluentQueryBuilder\Contracts\Arrayable;
use Kiyonori\ElasticsearchFluentQueryBuilder\MakeArrayableInstanceFromFirstParam;
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
        /** @var ?Arrayable $arrayableInstance */
        $arrayableInstance = app(MakeArrayableInstanceFromFirstParam::class)
            ->execute($callback);

        if ($arrayableInstance === null) {
            return $this;
        }

        $callback($arrayableInstance);

        $this->bool = $arrayableInstance->toArray();

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
