<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\MustQuery;
use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\Query;
use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\ShouldQuery;

test(
    'Query の bool メソッドが正しく機能すること',

    /**
     * @throws ReflectionException
     */
    function () {
        /** @var Query $query */
        $query = app(Query::class);

        $result = $query
            ->bool(
                function (MustQuery $must) {
                    $must
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
                        );
                }
            )
            ->toArray();

        expect($result)->toBe([
            'query' => [
                'bool' => [
                    [
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
                    [
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
