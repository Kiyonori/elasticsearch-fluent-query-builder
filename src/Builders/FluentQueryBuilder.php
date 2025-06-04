<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

use Closure;
use Kiyonori\ElasticsearchFluentQueryBuilder\Values\Nothing;

/**
 * Elasticsearch 検索クエリの組み立て
 */
final class FluentQueryBuilder
{
    private array $must = [];

    private array $filters = [];

    private array $should = [];

    private ?int $minimumShouldMatch = null;

    private array $mustNot = [];

    private ?int $from = null;

    private ?int $size = null;

    private array $searchAfters = [];

    private array $sorts = [];

    public function toArray(): array
    {
        $structure = [
            'body' => [
                'query'        => [
                    'bool' => [
                        'must' => ! empty($this->must)
                            ? $this->must
                            :Nothing::make(),

                        'filter' => ! empty($this->filters)
                            ? $this->filters
                            :Nothing::make(),

                        'should'               => when(
                            condition: ! empty($this->should),
                            value: fn() => $this->should,
                            default: Nothing::make(),
                        ),
                        'minimum_should_match' => when(
                            condition: isset($this->minimumShouldMatch),
                            value: fn() => $this->minimumShouldMatch,
                            default: Nothing::make(),
                        ),
                        'must_not'             => when(
                            condition: ! empty($this->mustNot),
                            value: fn() => $this->mustNot,
                            default: Nothing::make(),
                        ),
                    ],
                ],
                'from'         => when(
                    condition: isset($this->from),
                    value: fn() => $this->from,
                    default: Nothing::make(),
                ),
                'size'         => when(
                    condition: isset($this->size),
                    value: fn() => $this->size,
                    default: Nothing::make(),
                ),
                'search_after' => when(
                    condition: isset($this->searchAfters),
                    value: fn() => $this->searchAfters,
                    default: Nothing::make(),
                ),
                'sort'         => when(
                    condition: isset($this->sorts),
                    value: fn() => $this->sorts,
                    default: Nothing::make(),
                ),
            ],
        ];

        // TODO `Nothing` を持つ要素を取り除いてから return する
        return [];
    }

    public function must(Closure $callback): self
    {
        $builder = new Builder;

        $callback($builder);

        $this->must = array_merge(
            $this->must,
            $builder->toArray(),
        );

        return $this;
    }

    public function filter(Closure $callback): self
    {
        $builder = new Builder;

        $callback($builder);

        $this->filters = array_merge(
            $this->filters,
            $builder->toArray(),
        );

        return $this;
    }

    public function should(Closure $callback): self
    {
        $builder = new Builder;

        $callback($builder);

        $this->should = array_merge(
            $this->should,
            $builder->toArray(),
        );

        return $this;
    }

    public function minimumShouldMatch(int $value): self
    {
        $this->minimumShouldMatch = $value;

        return $this;
    }

    public function mustNot(Closure $callback): self
    {
        $builder = new Builder;

        $callback($builder);

        $this->mustNot = array_merge(
            $this->mustNot,
            $builder->toArray(),
        );

        return $this;
    }

    /**
     * @param  int  $offset  0から開始するオフセット値
     */
    public function from(int $offset): self
    {
        $this->from = $offset;

        return $this;
    }

    public function size(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function searchAfter(mixed $searchAfter): self
    {
        $this->searchAfters[] = $searchAfter;

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
}