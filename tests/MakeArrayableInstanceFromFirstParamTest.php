<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\ShouldQuery;
use Kiyonori\ElasticsearchFluentQueryBuilder\MakeArrayableInstanceFromFirstParam;

test(
    'クロージャの第一引数に渡した型が Arrayable である場合、そのインスタンスが返ってくること',
    function () {
        $result = app(MakeArrayableInstanceFromFirstParam::class)->execute(
            function (ShouldQuery $should) {}
        );

        expect($result)
            ->toBeInstanceOf(ShouldQuery::class);
    }
);
