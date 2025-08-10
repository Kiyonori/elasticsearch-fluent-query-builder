<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\MustNotQuery;

test(
    'MustNotQuery−＞term（）は、意図したクエリの形を組み立てること',
    function () {
        /** @var MustNotQuery $mustNot */
        $mustNot = app(MustNotQuery::class);

        $result = $mustNot
            ->term('field_1', 'value 111')
            ->term('field_2', 222.2)
            ->toArray();

        expect($result)->toBe([
            'must_not' => [
                ['term' => ['field_1' => 'value 111']],
                ['term' => ['field_2' => 222.2]],
            ],
        ]);
    }
);

test(
    'MustNotQuery−＞match（）は、意図したクエリの形を組み立てること',
    function () {
        /** @var MustNotQuery $mustNot */
        $mustNot = app(MustNotQuery::class);

        $result = $mustNot
            ->match('field_1', 'value 1')
            ->match('field_2', 222.2)
            ->match('field_3', true)
            ->toArray();

        expect($result)->toBe([
            'must_not' => [
                ['match' => ['field_1' => 'value 1']],
                ['match' => ['field_2' => 222.2]],
                ['match' => ['field_3' => true]],
            ],
        ]);
    }
);

test(
    'MustNotQuery のコンストラクタに belongsToBoolQuery：true を指定すると bool というキー名にラッピングされた値が組み立てられること',
    function () {
        /** @var MustNotQuery $mustNot */
        $mustNot = app(
            MustNotQuery::class,
            belongsToBoolQuery: true,
        );

        $result = $mustNot
            ->term('field_1', 'value 111')
            ->term('field_2', 222.2)
            ->toArray();

        expect($result)->toBe([
            'bool' => [
                'must_not' => [
                    ['term' => ['field_1' => 'value 111']],
                    ['term' => ['field_2' => 222.2]],
                ],
            ],
        ]);
    }
);
