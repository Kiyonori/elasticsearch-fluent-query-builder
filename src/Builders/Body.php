<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

use Closure;

/**
 * Elasticsearch DSL root.
 */
final class Body
{
    private array $query = [];

    private ?int $from = null;

    private ?int $size = null;

    private array $sorts = [];

    private array $searchAfters = [];

    public static function query(
        ?Closure $callback = null,
    ): self {
        $instance = new self;

        if ($callback === null) {
            return $instance;
        }

        /** @var Query $query */
        $query = app(Query::class);

        $callback($query);

        $instance->query = $query->toArray();

        return $instance;
    }

    public function from(int $offset): self
    {
        $this->from = $offset;

        return $this;
    }

    public function sort(
        string $fieldName,
        string $direction,
    ): self {
        $this->sorts[] = [
            $fieldName => [
                'order' => $direction,
            ],
        ];

        return $this;
    }

    public function size(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function searchAfter(int $searchAfter): self
    {
        $this->searchAfters[] = $searchAfter;

        return $this;
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
