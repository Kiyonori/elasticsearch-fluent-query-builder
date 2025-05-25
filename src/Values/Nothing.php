<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Values;

final readonly class Nothing
{
    public static function make(): self
    {
        return new self;
    }
}
