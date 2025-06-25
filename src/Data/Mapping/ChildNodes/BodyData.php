<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Data\Mapping\ChildNodes;

final readonly class BodyData
{
    public MappingsData $mappings;

    public function __construct(array $body)
    {
        $this->mappings = new MappingsData(
            mappings: $body['mappings']
        );
    }
}
