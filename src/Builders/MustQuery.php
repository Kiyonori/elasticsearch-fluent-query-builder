<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

use Closure;
use Kiyonori\ElasticsearchFluentQueryBuilder\Contracts\Arrayable;
use Kiyonori\ElasticsearchFluentQueryBuilder\GetFistParamClassNameInClosure;
use Kiyonori\ElasticsearchFluentQueryBuilder\Values\Nothing;

final class MustQuery implements Arrayable
{
    private array $bool = [];

    private ?int $minimumShouldMatch = null;

    public function bool(
        Closure $callback,
        ?int $minimumShouldMatch = null,
    ): self {
        $this->minimumShouldMatch = $minimumShouldMatch;

        /** @var ?string $classFqn */
        $classFqn = app(GetFistParamClassNameInClosure::class)
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

        $this->bool = $instance->toArray();

        return $this;
    }

    public function toArray(): array
    {
        return app(UnsetNothingKeyInArray::class)->execute(
            $this->bool
            +
            [
                'minimum_should_match' => $this->minimumShouldMatch ?? Nothing::make(),
            ]
        );
    }
}
