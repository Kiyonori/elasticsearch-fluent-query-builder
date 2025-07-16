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

    public function toArray(): array
    {
        return $this->_toArray($this);
    }

    private function _toArray(mixed $objectInstance): array
    {
        $output = [];

        $properties = get_object_vars($objectInstance);

        foreach ($properties as $key => $property) {
            $isPrimitive = in_array(
                needle: gettype($property),
                haystack: ['boolean', 'integer', 'double', 'string', 'array', 'NULL'],
                strict: true,
            );

            if ($isPrimitive) {
                $output[$key] = $property;

                continue;
            }

            $output[$key] = $this->_toArray($property);
        }

        return $output;
    }
}
