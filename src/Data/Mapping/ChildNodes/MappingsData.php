<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Data\Mapping\ChildNodes;

use stdClass;

final readonly class MappingsData
{
    public stdClass $properties;

    public function __construct(
        array $mappings
    ) {
        $this->properties = $this->arrayToStdClass(
            $mappings['properties'],
        );
    }

    /**
     * ネストされた array を再帰的に stdClass にキャストする
     */
    private function arrayToStdClass(
        array $data,
    ): stdClass {
        $stdClass = new stdClass;

        foreach ($data as $key => $datum) {
            if ( ! is_array($datum)) {
                $stdClass->$key = $datum;
                continue;
            }

            $stdClass->$key = $this->arrayToStdClass($datum);
        }

        return $stdClass;
    }
}
