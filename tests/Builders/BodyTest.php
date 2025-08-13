<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\Body;

test(
    'Body インスタンスの toArray メソッドは意図した形の array を出力すること その1',
    function () {
        $result = Body::query()
            ->toArray();

        expect($result)->toBe([
            'body' => [],
        ]);
    }
);

test(
    'Body インスタンスの toArray メソッドは意図した形の array を出力すること その2',
    function () {
        $result = Body::query()
            ->from(60)
            ->size(20)
            ->sort('field_1', 'asc')
            ->sort('field_2', 'desc')
            ->searchAfter(123)
            ->searchAfter(333)
            ->toArray();

        expect($result)->toBe([
            'body' => [
                'from' => 60,
                'size' => 20,
                'sort' => [
                    ['field_1' => ['order' => 'asc']],
                    ['field_2' => ['order' => 'desc']],
                ],
                'search_after' => [
                    123,
                    333,
                ],
            ],
        ]);
    }
);
