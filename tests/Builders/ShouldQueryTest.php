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
            ->minimumShouldMatch(1)
            ->toArray();

        expect($result)->toBe([
            'should' => [
                ['term' => ['field_1' => 'value 111']],
                ['term' => ['field_2' => 222.2]],
            ],
            'minimum_should_match' => 1,
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
