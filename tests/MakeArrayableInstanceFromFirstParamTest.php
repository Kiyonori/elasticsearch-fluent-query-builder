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

test(
    'クロージャの第一引数に渡した型が Arrayable でない場合、null が返ってくること',
    function () {
        $result = app(MakeArrayableInstanceFromFirstParam::class)->execute(
            function (stdClass $std) {}
        );

        expect($result)
            ->toBeNull();
    }
);

test(
    'クロージャの第一引数に何も渡さなかった場合、null が返ってくること',
    function () {
        $result = app(MakeArrayableInstanceFromFirstParam::class)->execute(
            function () {}
        );

        expect($result)
            ->toBeNull();
    }
);

test(
    'クロージャすら渡さなかった場合、null が返ってくること',
    function () {
        $result = app(MakeArrayableInstanceFromFirstParam::class)
            ->execute();

        expect($result)
            ->toBeNull();
    }
);
