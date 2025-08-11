<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\Fluent;
use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\MustQuery;
use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\ShouldQuery;

test(
    'MustQuery の bool メソッドが正しく機能すること',
    function () {
        /** @var MustQuery $must */
        $must = app(MustQuery::class);

        $result = $must
            ->bool(
                function (Fluent $must) {
                    $must
                        ->bool(
                            function (ShouldQuery $should) {
                                $should
                                    ->match('field_1', 'value1')
                                    ->match('field_2', 'value 2')
                                    ->minimumShouldMatch(1);
                            }
                        )
                        ->bool(
                            function (ShouldQuery $should) {
                                $should
                                    ->match('field_3', 'value 333')
                                    ->match('field_4', 'value四')
                                    ->match('field_5', 'value５')
                                    ->minimumShouldMatch(2);
                            }
                        );
                }
            )
            ->toArray();

        expect($result)->toBe([
            'bool' => [
                [
                    'bool' => [
                        'should' => [
                            ['match' => ['field_1' => 'value1']],
                            ['match' => ['field_2' => 'value 2']],
                        ],
                        'minimum_should_match' => 1,
                    ],
                ],
                [
                    'bool' => [
                        'should' => [
                            ['match' => ['field_3' => 'value 333']],
                            ['match' => ['field_4' => 'value四']],
                            ['match' => ['field_5' => 'value５']],
                        ],
                        'minimum_should_match' => 2,
                    ],
                ],
            ],
        ]);
    }
);
