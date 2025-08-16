<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\FilterQuery;
use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\ShouldQuery;

test(
    'FilterQuery の bool メソッドが正しく機能すること',
    function () {
        /** @var FilterQuery $filter */
        $filter = app(FilterQuery::class);

        $result = $filter
            ->bool(
                function (ShouldQuery $should) {
                    $should
                        ->match('field_1', 'value1')
                        ->match('field_2', 'value 2');
                },
                minimumShouldMatch: 1,
            )
            ->bool(
                function (ShouldQuery $should) {
                    $should
                        ->match('field_3', 'value 333')
                        ->match('field_4', 'value四')
                        ->match('field_5', 'value５');
                },
                minimumShouldMatch: 2,
            )
            ->toArray();

        expect($result)->toBe([
            'filter' => [
                [
                    'bool' => [
                        'should' => [
                            [
                                'match' => [
                                    'field_1' => 'value1',
                                ],
                            ],
                            [
                                'match' => [
                                    'field_2' => 'value 2',
                                ],
                            ],
                        ],
                        'minimum_should_match' => 1,
                    ],
                ],
                [
                    'bool' => [
                        'should' => [
                            [
                                'match' => [
                                    'field_3' => 'value 333',
                                ],
                            ],
                            [
                                'match' => [
                                    'field_4' => 'value四',
                                ],
                            ],
                            [
                                'match' => [
                                    'field_5' => 'value５',
                                ],
                            ],
                        ],
                        'minimum_should_match' => 2,
                    ],
                ],
            ],
        ]);
    }
);

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
