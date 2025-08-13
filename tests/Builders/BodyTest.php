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
