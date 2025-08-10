<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\FilterQuery;

test(
    'FilterQuery−＞term（）は、意図したクエリの形を組み立てること',
    function () {
        /** @var FilterQuery $filter */
        $filter = app(FilterQuery::class);

        $result = $filter
            ->term('field_1', 'value 111')
            ->term('field_2', 222.2)
            ->toArray();

        expect($result)->toBe([
            'filter' => [
                ['term' => ['field_1' => 'value 111']],
                ['term' => ['field_2' => 222.2]],
            ],
        ]);
    }
);
