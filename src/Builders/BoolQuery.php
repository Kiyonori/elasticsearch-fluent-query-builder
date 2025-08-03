<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

use Kiyonori\ElasticsearchFluentQueryBuilder\Values\Nothing;

final class BoolQuery
{
    private array $matches = [];

    private ?int $minimumMatch = null;

    public static function should(): self
    {
        return new self;
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

    public function minimumShouldMatch(
        int $minimumMatch,
    ): self {
        $this->minimumMatch = $minimumMatch;

        return $this;
    }

    public function toArray(): array
    {
        $result = [
            'bool' => [
                'should'               => $this->matches,
                'minimum_should_match' => $this->minimumMatch ?? Nothing::make(),
            ],
        ];

        return app(UnsetNothingKeyInArray::class)->execute(
            $result
        );
    }
}
