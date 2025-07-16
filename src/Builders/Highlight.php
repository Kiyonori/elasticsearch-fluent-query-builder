<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Builders;

use Kiyonori\ElasticsearchFluentQueryBuilder\Values\Nothing;
use Kiyonori\ElasticsearchFluentQueryBuilder\Values\StaticStd;

final class Highlight
{
    private array $field = [];

    public function toArray(): array
    {
        return $this->field;
    }

    public function fields(
        string $fieldName,
        ?int $fragmentSize = null,
        ?int $numberOfFragments = null,
    ): self {
        if ($fragmentSize === null && $numberOfFragments === null) {
            $this->field[$fieldName] = StaticStd::instance();

            return $this;
        }

        $this->field[$fieldName] = [
            'fragment_size' => is_int($fragmentSize)
                ? $fragmentSize
                : Nothing::make(),

            'number_of_fragments' => is_int($numberOfFragments)
                ? $numberOfFragments
                : Nothing::make(),
        ];

        return $this;
    }
}
