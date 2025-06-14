<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Data\Mapping\ChildNodes;

use stdClass;

final readonly class MappingsData
{
    public stdClass $properties;

    public function __construct(
        array $mappings
    ) {
        $this->properties = json_decode(
            json_encode($mappings['properties'])
        );
    }
}
