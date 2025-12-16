<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\ShouldQuery;

test(
    'ShouldQuery−＞term（）は、意図したクエリの形を組み立てること',
    function () {
        /** @var ShouldQuery $should */
        $should = app(ShouldQuery::class);

        $result = $should
            ->term('field_1', 'value 111')
            ->term('field_2', 222.2)
            ->toArray();

        expect($result)->toBe([
            'should' => [
                ['term' => ['field_1' => 'value 111']],
                ['term' => ['field_2' => 222.2]],
            ],
        ]);
    }
);

test(
    'ShouldQuery−＞match（）は、意図したクエリの形を組み立てること',
    function () {
        /** @var ShouldQuery $should */
        $should = app(ShouldQuery::class);

        $result = $should
            ->match('field_1', 'value 1')
            ->match('field_2', 222.2)
            ->match('field_3', true)
            ->toArray();

        expect($result)->toBe([
            'should' => [
                ['match' => ['field_1' => 'value 1']],
                ['match' => ['field_2' => 222.2]],
                ['match' => ['field_3' => true]],
            ],
        ]);
    }
);

test(
    'ShouldQuery−＞multiMatch（）は、意図したクエリの形を組み立てること',
    function () {
        /** @var ShouldQuery $should */
        $should = app(ShouldQuery::class);

        $result = $should
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
            )
            ->toArray();

        expect($result)->toBe([
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
        ]);
    }
);

test(
    'ShouldQuery-＞term（）-＞match（）を併用した場合、意図したクエリの形を組み立てること',
    function () {
        /** @var ShouldQuery $should */
        $should = app(ShouldQuery::class);

        $result = $should
            ->term('field_1', 'value 111')
            ->term('field_2', 222.2)
            ->match('field_3', 'value 1')
            ->match('field_4', 222.2)
            ->match('field_5', true)
            ->toArray();

        expect($result)->toBe([
            'should' => [
                ['term' => ['field_1' => 'value 111']],
                ['term'  => ['field_2' => 222.2]],
                ['match' => ['field_3' => 'value 1']],
                ['match' => ['field_4' => 222.2]],
                ['match' => ['field_5' => true]],
            ],
        ]);
    }
);
