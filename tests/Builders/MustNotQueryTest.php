<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\MustNotQuery;
use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\ShouldQuery;

test(
    'MustNotQuery の bool メソッドが正しく機能すること',
    function () {
        /** @var MustNotQuery $must_not */
        $must_not = app(MustNotQuery::class);

        $result = $must_not
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
            'must_not' => [
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
