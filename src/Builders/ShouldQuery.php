<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

use Kiyonori\ElasticsearchFluentQueryBuilder\Values\Nothing;

final class ShouldQuery
{
    private array $terms = [];

    private array $matches = [];

    private ?int $minimumMatch = null;

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

    public function minimumShouldMatch(
        int $minimumMatch,
    ): self {
        $this->minimumMatch = $minimumMatch;

        return $this;
    }

    public function toArray(): array
    {
        $result = [
            'should' => (function () {
                if (count($this->terms) >= 1) {
                    return $this->terms;
                }

                if (count($this->matches) >= 1) {
                    return $this->matches;
                }

                return Nothing::make();
            })(),

            'minimum_should_match' => $this->minimumMatch ?? Nothing::make(),
        ];

        return app(UnsetNothingKeyInArray::class)->execute(
            $result
        );
    }
}
