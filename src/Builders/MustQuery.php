<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

use Kiyonori\ElasticsearchFluentQueryBuilder\Values\Nothing;

final class MustQuery
{
    private array $terms = [];

    private array $matches = [];

    public function __construct(
        private readonly bool $belongsToBoolQuery = false,
    ) {}

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
        $must = [
            'must' => (function () {
                if (count($this->terms) >= 1) {
                    return $this->terms;
                }

                if (count($this->matches) >= 1) {
                    return $this->matches;
                }

                return Nothing::make();
            })(),
        ];

        $result = match ($this->belongsToBoolQuery) {
            true => [
                'bool' => $must,
            ],

            default => $must,
        };

        return app(UnsetNothingKeyInArray::class)->execute(
            $result
        );
    }
}
