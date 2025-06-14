<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Data\Mapping;

use Kiyonori\ElasticsearchFluentQueryBuilder\Data\Mapping\ChildNodes\BodyData;

final readonly class JsonData
{
    public BodyData $body;

    public function __construct(
        public string $index,
        array $body,
    ) {
        $this->body = new BodyData(
            body: $body
        );
    }
}
