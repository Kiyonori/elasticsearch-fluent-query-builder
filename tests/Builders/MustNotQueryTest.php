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
