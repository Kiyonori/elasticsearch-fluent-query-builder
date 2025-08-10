<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

final class MatchQuery
{
    private array $matches = [];

    public function match(
        string $fieldName,
        mixed $value,
    ): self {
        $this->matches[] = [
            'match' => [
                $fieldName => $value,
            ],
        ];

        return $this;
    }

    public function toArray(): array
    {
        return $this->matches;
    }
}
