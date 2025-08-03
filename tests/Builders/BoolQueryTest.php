<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\BoolQuery;

test(
    'BoolQuery は、意図したクエリの形を組み立てること',
    function () {
        $result = BoolQuery::should()
            ->match('field_1', 'value 1')
            ->match('field_2', 222.2)
            ->minimumShouldMatch(1)
            ->toArray();

        expect($result)->toBe([
            'bool' => [
                'should' => [
                    ['match' => ['field_1' => 'value 1']],
                    ['match' => ['field_2' => 222.2]],
                ],
                'minimum_should_match' => 1,
            ],
        ]);
    }
);
