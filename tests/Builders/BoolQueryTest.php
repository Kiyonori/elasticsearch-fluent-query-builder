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

test(
    'BoolQuery は、minimum_should_match を省略可能であり、省略した場合は含まれないこと',
    function () {
        $result = BoolQuery::should()
            ->match('field_1', 'value 1')
            ->match('field_2', 222.2)
            ->match('field_3', true)
            // ->minimumShouldMatch(2)
            ->toArray();

        expect($result)->toBe([
            'bool' => [
                'should' => [
                    ['match' => ['field_1' => 'value 1']],
                    ['match' => ['field_2' => 222.2]],
                    ['match' => ['field_3' => true]],
                ],
                // 'minimum_should_match' => 2,
            ],
        ]);
    }
);

test(
    'BoolQuery：：should（）−＞term 検索条件を組み立てられること',
    function () {
        $result = BoolQuery::should()
            ->term('field_1', 'value 1')
            ->term('field_2', 222.2)
            ->toArray();

        expect($result)->toBe([
            'bool' => [
                'should' => [
                    ['term' => ['field_1' => 'value 1']],
                    ['term' => ['field_2' => 222.2]],
                ],
            ],
        ]);
    }
);
