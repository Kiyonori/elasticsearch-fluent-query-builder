<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

/**
 * 検索条件の組み立て
 */
final class Builder
{
    private array $filters = [];

    public function toArray(): array
    {
        return $this->filters;
    }

    public function term(
        string $fieldName,
        mixed $value,
    ): self {
        $this->filters[] = [
            'term' => [$fieldName => $value],
        ];

        return $this;
    }

    public function match(
        string $fieldName,
        mixed $value,
    ): self {
        $this->filters[] = [
            'match' => [$fieldName => $value],
        ];

        return $this;
    }

    public function range(
        string $fieldName,
        mixed $gte,
        mixed $lte,
    ): self {
        $this->filters[] = [
            'range' => [
                $fieldName => [
                    'gte' => $gte,
                    'lte' => $lte,
                ],
            ],
        ];

        return $this;
    }
}
