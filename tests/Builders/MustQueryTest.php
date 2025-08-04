<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\MustQuery;

test(
    'MustQuery−＞term（）は、意図したクエリの形を組み立てること',
    function () {
        /** @var MustQuery $must */
        $must = app(MustQuery::class);

        $result = $must
            ->term('field_1', 'value 111')
            ->term('field_2', 222.2)
            ->toArray();

        expect($result)->toBe([
            'must' => [
                ['term' => ['field_1' => 'value 111']],
                ['term' => ['field_2' => 222.2]],
            ],
        ]);
    }
);
