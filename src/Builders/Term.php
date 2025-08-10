<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

final class Term
{
    private array $terms = [];

    public function term(
        string $fieldName,
        mixed $value,
    ): self {
        $this->terms[] = [
            'term' => [
                $fieldName => $value,
            ],
        ];

        return $this;
    }

    public function toArray(): array
    {
        return $this->terms;
    }
}
