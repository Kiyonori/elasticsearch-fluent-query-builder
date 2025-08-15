<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\Body;
use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\MustQuery;

test(
    'Body インスタンスの toArray メソッドは意図した形の array を出力すること その1',
    function () {
        $result = Body::query()
            ->toArray();

        expect($result)->toBe([
            'body' => [],
        ]);
    }
);

test(
    'Body インスタンスの toArray メソッドは意図した形の array を出力すること その2',
    function () {
        $result = Body::query()
            ->from(60)
            ->size(20)
            ->sort('field_1', 'asc')
            ->sort('field_2', 'desc')
            ->searchAfter(123)
            ->searchAfter(333)
            ->toArray();

        expect($result)->toBe([
            'body' => [
                'from' => 60,
                'size' => 20,
                'sort' => [
                    ['field_1' => ['order' => 'asc']],
                    ['field_2' => ['order' => 'desc']],
                ],
                'search_after' => [
                    123,
                    333,
                ],
            ],
        ]);
    }
);

test(
    'Body インスタンスの toArray メソッドは意図した形の array を出力すること その3',
    function () {
        $result = Body::query(
            function (MustQuery $must) {
                $must
                    ->term('chat_id', 'u968edd043c46262efe69ef21ad458c6d')
                    ->term('type', 1)
                    ->match('content', 'おはよう')
                    ->match('content', '今度')
                    ->range(
                        fieldName: 'created_time',
                        gte: 1736925752798,
                    )
                    ->range('id', 333, 555);
            }
        )->toArray();

        expect($result)->toBe([
            'body' => [
                'query' => [
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
                ],
            ],
        ]);
    }
);
