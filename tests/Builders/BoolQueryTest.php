<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\BoolQuery;
use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\MustQuery;
use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\ShouldQuery;

test(
    'BoolQuery の toArray メソッドは意図した形の array を出力すること その1',
    function () {
        /** @var BoolQuery $bool */
        $bool = app(BoolQuery::class);

        $result = $bool(
            function (MustQuery $must) {
                $must
                    ->term('chat_id', 'u968edd043c46262efe69ef21ad458c6d')
                    ->term('type', 1)
                    ->match('content', 'おはよう')
                    ->range(
                        fieldName: 'created_time',
                        gte: 1736925752798,
                    )
                    ->range(
                        fieldName: 'id',
                        gte: 333,
                        lte: 555,
                    );
            }
        )->toArray();

        expect($result)->toBe([
            'bool' => [
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
            ],
        ]);
    }
);

test(
    'BoolQuery の toArray メソッドは意図した形の array を出力すること その2',
    function () {
        /** @var BoolQuery $bool */
        $bool = app(BoolQuery::class);

        $result = $bool(
            function (ShouldQuery $should) {
                $should
                    ->term('chat_id', 'u968edd043c46262efe69ef21ad458c6d')
                    ->term('type', 1)
                    ->match('content', 'おはよう')
                    ->range(
                        fieldName: 'created_time',
                        gte: 1736925752798,
                    )
                    ->range(
                        fieldName: 'id',
                        gte: 333,
                        lte: 555,
                    );
            },
            minimumShouldMatch: 1,
        )->toArray();

        expect($result)->toBe([
            'bool' => [
                'should' => [
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
                'minimum_should_match' => 1,
            ],
        ]);
    }
);
