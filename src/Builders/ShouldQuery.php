<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

use Kiyonori\ElasticsearchFluentQueryBuilder\Contracts\Arrayable;
use Kiyonori\ElasticsearchFluentQueryBuilder\Values\Nothing;

final class ShouldQuery implements Arrayable
{
    private array $terms = [];

    private array $matches = [];

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
        $internal = array_merge(
            $this->terms,
            $this->matches,
        ) ?: Nothing::make();

        return app(UnsetNothingKeyInArray::class)->execute(
            ['should' => $internal]
        );
    }
}
