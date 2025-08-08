<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\ShouldQuery;
use Kiyonori\ElasticsearchFluentQueryBuilder\Enums\QueryTypeEnum;

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

test(
    'ShouldQuery−＞term（）は、minimum_should_match を省略可能であり、省略した場合は含まれないこと',
    function () {
        /** @var ShouldQuery $should */
        $should = app(ShouldQuery::class);

        $result = $should
            ->term('field_1', 'value 1')
            ->term('field_2', 222.2)
            ->term('field_3', true)
            // ->minimumShouldMatch(2)
            ->toArray();

        expect($result)->toBe([
            'should' => [
                ['term' => ['field_1' => 'value 1']],
                ['term' => ['field_2' => 222.2]],
                ['term' => ['field_3' => true]],
            ],
            // 'minimum_should_match' => 2,
        ]);
    }
);

test(
    'ShouldQuery のコンストラクタに QueryTypeEnum::BOOL を指定すると bool というキー名にラッピングされた値が組み立てられること',
    function () {
        /** @var ShouldQuery $should */
        $should = app(
            ShouldQuery::class,
            QueryTypeEnum::BOOL,
        );

        $result = $should
            ->term('field_1', 'value 111')
            ->term('field_2', 222.2)
            ->minimumShouldMatch(1)
            ->toArray();

        expect($result)->toBe([
            'bool' => [
                'should' => [
                    ['term' => ['field_1' => 'value 111']],
                    ['term' => ['field_2' => 222.2]],
                ],
                'minimum_should_match' => 1,
            ],
        ]);
    }
);
