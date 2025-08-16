<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\MustQuery;
use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\ShouldQuery;

test(
    'MustQuery の bool メソッドが正しく機能すること',
    function () {
        /** @var MustQuery $must */
        $must = app(MustQuery::class);

        $result = $must
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
            'must' => [
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
    'MustQuery の term，match，range メソッドが正しく機能すること',
    function () {
        /** @var MustQuery $must */
        $must = app(MustQuery::class);

        $result = $must
            ->term('chat_id', 'u968edd043c46262efe69ef21ad458c6d')
            ->term('type', 1)
            ->match('content', 'おはよう')
            ->match('content', '今度')
            ->range(
                fieldName: 'created_time',
                gte: 1736925752798,
            )
            ->range('id', 333, 555)
            ->toArray();

        expect($result)->toBe([
            'must' => [
                [
                    'term' => ['chat_id' => 'u968edd043c46262efe69ef21ad458c6d'],
                ],
                [
                    'term' => ['type' => 1],
                ],
                [
                    'match' => ['content' => 'おはよう'],
                ],
                [
                    'match' => ['content' => '今度'],
                ],
                [
                    'range' => [
                        'created_time' => [
                            'gte' => 1736925752798,
                        ],
                    ],
                ],
                [
                    'range' => [
                        'id' => [
                            'gte' => 333,
                            'lte' => 555,
                        ],
                    ],
                ],
            ],
        ]);
    }
);
