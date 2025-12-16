<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\Body;
use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\BoolQuery;
use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\Highlight;
use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\MustQuery;
use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\ShouldQuery;

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
            function (BoolQuery $bool) {
                $bool(
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
                );
            }
        )->toArray();

        expect($result)->toBe([
            'body' => [
                'query' => [
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
            ],
        ]);
    }
);

test(
    'Body インスタンスの toArray メソッドは意図した形の array を出力すること その4',
    function () {
        $result = Body::query(
            function (BoolQuery $bool) {
                $bool(
                    function (ShouldQuery $should) {
                        $should
                            ->match('field_1', 'value 1')
                            ->match('field_2', 222.2)
                            ->match('field_3', true);
                    },
                    minimumShouldMatch: 1,
                );
            }
        )->toArray();

        expect($result)->toBe([
            'body' => [
                'query' => [
                    'bool' => [
                        'should' => [
                            [
                                'match' => ['field_1' => 'value 1'],
                            ],
                            [
                                'match' => ['field_2' => 222.2],
                            ],
                            [
                                'match' => ['field_3' => true],
                            ],
                        ],
                        'minimum_should_match' => 1,
                    ],
                ],
            ],
        ]);
    }
);

test(
    'Body インスタンスの toArray メソッドは意図した形の array を出力すること その5',
    function () {
        $result = Body::query(
            function (BoolQuery $bool) {
                $bool(
                    function (ShouldQuery $should) {
                        $should
                            ->match('content', 'おはよう')
                            ->match('field_1', 'value 1')
                            ->term('field_2', 222.2)
                            ->term('field_3', true);
                    },
                    minimumShouldMatch: 1,
                );
            })
            ->highlight(
                function (Highlight $highlight) {
                    $highlight
                        ->field(
                            fieldName: 'content',
                            fragmentSize: 150,
                            numberOfFragments: 3,
                        )
                        ->field(
                            fieldName: 'chat_id',
                        );
                }
            )
            ->toArray();

        expect($result)->toBe([
            'body' => [
                'query' => [
                    'bool' => [
                        'should' => [
                            [
                                'match' => ['content' => 'おはよう'],
                            ],
                            [
                                'match' => ['field_1' => 'value 1'],
                            ],
                            [
                                'term' => ['field_2' => 222.2],
                            ],
                            [
                                'term' => ['field_3' => true],
                            ],
                        ],
                        'minimum_should_match' => 1,
                    ],
                ],
                'highlight' => [
                    'fields' => [
                        'content' => [
                            'fragment_size'       => 150,
                            'number_of_fragments' => 3,
                        ],
                    ],
                ],
            ],
        ]);
    }
);

test(
    'Body インスタンスの toArray メソッドは意図した形の array を出力すること その6',
    function () {
        $result = Body::query(
            function (BoolQuery $bool) {
                $bool(
                    function (ShouldQuery $should) {
                        $should
                            ->match('content', 'おはよう')
                            ->match('field_1', 'value 1')
                            ->term('field_2', 222.2)
                            ->term('field_3', true);
                    },
                    minimumShouldMatch: 1,
                );
            })
            ->highlight(
                function (Highlight $highlight) {
                    $highlight
                        ->field(
                            fieldName: 'content',
                            fragmentSize: 150,
                            numberOfFragments: 3,
                        )
                        ->field(
                            fieldName: 'chat_id',
                        )
                        ->preTags(['<em>'])
                        ->postTags(['</em>']);
                }
            )
            ->toArray();

        expect($result)->toBe([
            'body' => [
                'query' => [
                    'bool' => [
                        'should' => [
                            [
                                'match' => ['content' => 'おはよう'],
                            ],
                            [
                                'match' => ['field_1' => 'value 1'],
                            ],
                            [
                                'term' => ['field_2' => 222.2],
                            ],
                            [
                                'term' => ['field_3' => true],
                            ],
                        ],
                        'minimum_should_match' => 1,
                    ],
                ],
                'highlight' => [
                    'fields' => [
                        'content' => [
                            'fragment_size'       => 150,
                            'number_of_fragments' => 3,
                        ],
                    ],
                    'pre_tags'  => ['<em>'],
                    'post_tags' => ['</em>'],
                ],
            ],
        ]);
    }
);

test(
    'Body インスタンスの toArray メソッドは意図した形の array を出力すること その7',
    function () {
        $result = Body::query(
            function (BoolQuery $bool) {
                $bool(
                    function (ShouldQuery $should) {
                        $should
                            ->match('content', 'おはよう')
                            ->match('field_1', 'value 1')
                            ->term('field_2', 222.2)
                            ->term('field_3', true);
                    },
                    minimumShouldMatch: 1,
                );
            })
            ->highlight(
                function (Highlight $highlight) {
                    $highlight
                        ->field(
                            fieldName: 'content',
                            fragmentSize: 150,
                            numberOfFragments: 3,
                        )
                        ->field(
                            fieldName: 'chat_id',
                        )
                        ->preTags(['<em>', '<strong>'])
                        ->postTags(['</em>', '</strong>']);
                }
            )
            ->toArray();

        expect($result)->toBe([
            'body' => [
                'query' => [
                    'bool' => [
                        'should' => [
                            [
                                'match' => ['content' => 'おはよう'],
                            ],
                            [
                                'match' => ['field_1' => 'value 1'],
                            ],
                            [
                                'term' => ['field_2' => 222.2],
                            ],
                            [
                                'term' => ['field_3' => true],
                            ],
                        ],
                        'minimum_should_match' => 1,
                    ],
                ],
                'highlight' => [
                    'fields' => [
                        'content' => [
                            'fragment_size'       => 150,
                            'number_of_fragments' => 3,
                        ],
                    ],
                    'pre_tags' => [
                        '<em>',
                        '<strong>',
                    ],
                    'post_tags' => [
                        '</em>',
                        '</strong>',
                    ],
                ],
            ],
        ]);
    }
);

test(
    'Body インスタンスの toArray メソッドは意図した形の array を出力すること その8',
    function () {
        $result = Body::query(
            function (BoolQuery $bool) {
                $bool(
                    function (MustQuery $must) {
                        $must->bool(
                            function (ShouldQuery $should) {
                                $should
                                    ->multiMatch(
                                        query: '鈴木',
                                        fields: [
                                            'user_street_address.ngram',
                                            'user_city.ngram',
                                            'user_last_name.ngram',
                                            'user_first_name.ngram',
                                            'user_last_kana_name.ngram',
                                            'user_first_kana_name.ngram',
                                            'pet_name.ngram',
                                        ],
                                    );
                            },
                            minimumShouldMatch: 1,
                        )->bool(function (ShouldQuery $should) {
                            $should
                                ->multiMatch(
                                    query: '太郎',
                                    fields: [
                                        'user_street_address.ngram',
                                        'user_city.ngram',
                                        'user_last_name.ngram',
                                        'user_first_name.ngram',
                                        'user_last_kana_name.ngram',
                                        'user_first_kana_name.ngram',
                                        'pet_name.ngram',
                                    ],
                                );
                        },
                            minimumShouldMatch: 1,
                        );
                    }
                );
            })
            ->toArray();

        expect($result)
            ->toBe([
                'body' => [
                    'query' => [
                        'bool' => [
                            'must' => [
                                [
                                    'bool' => [
                                        'should' => [
                                            [
                                                'multi_match' => [
                                                    'query'  => '鈴木',
                                                    'fields' => [
                                                        'user_street_address.ngram',
                                                        'user_city.ngram',
                                                        'user_last_name.ngram',
                                                        'user_first_name.ngram',
                                                        'user_last_kana_name.ngram',
                                                        'user_first_kana_name.ngram',
                                                        'pet_name.ngram',
                                                    ],
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
                                                'multi_match' => [
                                                    'query'  => '太郎',
                                                    'fields' => [
                                                        'user_street_address.ngram',
                                                        'user_city.ngram',
                                                        'user_last_name.ngram',
                                                        'user_first_name.ngram',
                                                        'user_last_kana_name.ngram',
                                                        'user_first_kana_name.ngram',
                                                        'pet_name.ngram',
                                                    ],
                                                ],
                                            ],
                                        ],
                                        'minimum_should_match' => 1,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]);
    }
);
