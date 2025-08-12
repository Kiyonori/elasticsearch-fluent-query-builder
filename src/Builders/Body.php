<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

use Closure;

/**
 * Elasticsearch DSL root.
 */
final class Body
{
    private array $query = [];

    public static function query(
        Closure $callback,
    ): self {
        /** @var Query $query */
        $query = app(Query::class);

        $callback($query);

        $instance = new self;

        $instance->query = $query->toArray();

        return $instance;
    }

    public function from(): self
    {
        // TODO Implements...
    }

    public function sort(): self
    {
        // TODO Implements...
    }

    public function searchAfter(): self
    {
        // TODO Implements...
    }

    public function toArray(): array
    {
        return [
            'body' => [
                'query' => $this->query,
            ],
        ];
    }
}
