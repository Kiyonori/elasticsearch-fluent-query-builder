<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

use Closure;
use Kiyonori\ElasticsearchFluentQueryBuilder\Contracts\Arrayable;

final class Fluent implements Arrayable
{
    private array $bools = [];

    public function bool(
        Closure $callback,
    ): self {
        /** @var ShouldQuery $shouldQuery */
        $shouldQuery = app(ShouldQuery::class);

        $callback($shouldQuery);

        $this->bools[]['bool'] = $shouldQuery->toArray();

        return $this;
    }

    public function toArray(): array
    {
        return $this->bools;
    }
}
