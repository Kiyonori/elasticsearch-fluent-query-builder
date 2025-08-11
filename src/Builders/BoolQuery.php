<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

use Closure;

final class BoolQuery
{
    private array $bools = [];

    public function must(
        Closure $callback,
    ): self {
        /** @var Fluent $fluent */
        $fluent = app(Fluent::class);

        $callback($fluent);

        $this->bools[]['bool'] = $fluent->toArray();

        return $this;
    }
}
