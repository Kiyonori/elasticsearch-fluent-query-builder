<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\FilterQuery;

test(
    'FilterQuery−＞term（）は、意図したクエリの形を組み立てること',
    function () {
        /** @var FilterQuery $filter */
        $filter = app(FilterQuery::class);

        $result = $filter
            ->term('field_1', 'value 111')
            ->term('field_2', 222.2)
            ->toArray();

        expect($result)->toBe([
            'filter' => [
                ['term' => ['field_1' => 'value 111']],
                ['term' => ['field_2' => 222.2]],
            ],
        ]);
    }
);

test(
    'FilterQuery−＞match（）は、意図したクエリの形を組み立てること',
    function () {
        /** @var FilterQuery $filter */
        $filter = app(FilterQuery::class);

        $result = $filter
            ->match('field_1', 'value 1')
            ->match('field_2', 222.2)
            ->match('field_3', true)
            ->toArray();

        expect($result)->toBe([
            'filter' => [
                ['match' => ['field_1' => 'value 1']],
                ['match' => ['field_2' => 222.2]],
                ['match' => ['field_3' => true]],
            ],
        ]);
    }
);

test(
    'FilterQuery のコンストラクタに belongsToBoolQuery：true を指定すると bool というキー名にラッピングされた値が組み立てられること',
    function () {
        /** @var FilterQuery $filter */
        $filter = app(
            FilterQuery::class,
            belongsToBoolQuery: true,
        );

        $result = $filter
            ->term('field_1', 'value 111')
            ->term('field_2', 222.2)
            ->toArray();

        expect($result)->toBe([
            'bool' => [
                'filter' => [
                    ['term' => ['field_1' => 'value 111']],
                    ['term' => ['field_2' => 222.2]],
                ],
            ],
        ]);
    }
);
