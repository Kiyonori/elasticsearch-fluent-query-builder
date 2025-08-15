<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

use Closure;
use Kiyonori\ElasticsearchFluentQueryBuilder\Contracts\Arrayable;
use Kiyonori\ElasticsearchFluentQueryBuilder\GetFirstParamClassNameInClosure;
use Kiyonori\ElasticsearchFluentQueryBuilder\Values\Nothing;

final class MustQuery implements Arrayable
{
    private ?array $internal = [];

    public function bool(
        Closure $callback,
        ?int $minimumShouldMatch = null,
    ): self {
        /** @var ?string $classFqn */
        $classFqn = app(GetFirstParamClassNameInClosure::class)
            ->execute($callback);

        if ($classFqn === null) {
            return $this;
        }

        /** @var Arrayable|object $instance */
        $instance = app($classFqn);

        $isArrayable = $instance instanceof Arrayable;

        if ($isArrayable === false) {
            return $this;
        }

        $callback($instance);

        $this->internal[] = $instance->toArray()
            +
            [
                'minimum_should_match' => $minimumShouldMatch ?? Nothing::make(),
            ];

        return $this;
    }

    public function term(
        string $fieldName,
        mixed $value,
    ): self {
        $this->internal['must'][] = [
            'term' => [$fieldName => $value],
        ];

        return $this;
    }

    public function match(
        string $fieldName,
        mixed $value,
    ): self {
        $this->internal['must'][] = [
            'match' => [$fieldName => $value],
        ];

        return $this;
    }

    public function range(
        string $fieldName,
        mixed $gte = null,
        mixed $lte = null,
    ): self {
        $this->internal['must'][] = [
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
