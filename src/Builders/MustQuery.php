<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

use Closure;

final class MustQuery
{
    private array $bools = [];

    public function bool(
        Closure $callback,
    ): self {
        /** @var Fluent $fluent */
        $fluent = app(Fluent::class);

        $callback($fluent);

        $this->bools['bool'] = $fluent->toArray();

        return $this;
    }

    public function toArray(): array
    {
        return $this->bools;
    }
}
