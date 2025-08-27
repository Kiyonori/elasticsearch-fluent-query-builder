<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

use Closure;
use Kiyonori\ElasticsearchFluentQueryBuilder\Contracts\Arrayable;
use Kiyonori\ElasticsearchFluentQueryBuilder\MakeArrayableInstanceFromFirstParam;
use Kiyonori\ElasticsearchFluentQueryBuilder\Values\Nothing;

final class FilterQuery implements Arrayable
{
    private array $internal = [];

    public function bool(
        Closure $callback,
        ?int $minimumShouldMatch = null,
    ): self {
        /** @var ?Arrayable $arrayableInstance */
        $arrayableInstance = app(MakeArrayableInstanceFromFirstParam::class)
            ->execute($callback);

        if ($arrayableInstance === null) {
            return $this;
        }

        $callback($arrayableInstance);

        $this->internal['filter'][] = [
            'bool' => $arrayableInstance->toArray()
                +
                [
                    'minimum_should_match' => $minimumShouldMatch ?? Nothing::make(),
                ],
        ];

        return $this;
    }

    public function term(
        string $fieldName,
        mixed $value,
    ): self {
        $this->internal['filter'][] = [
            'term' => [$fieldName => $value],
        ];

        return $this;
    }

    public function match(
        string $fieldName,
        mixed $value,
    ): self {
        $this->internal['filter'][] = [
            'match' => [$fieldName => $value],
        ];

        return $this;
    }

    public function range(
        string $fieldName,
        mixed $gte = null,
        mixed $lte = null,
    ): self {
        $this->internal['filter'][] = [
            'range' => [
                $fieldName => [
                    'gte' => $gte ?? Nothing::make(),
                    'lte' => $lte ?? Nothing::make(),
                ],
            ],
        ];

        return $this;
    }

    public function toArray(): array
    {
        return app(UnsetNothingKeyInArray::class)->execute(
            $this->internal,
        );
    }
}
