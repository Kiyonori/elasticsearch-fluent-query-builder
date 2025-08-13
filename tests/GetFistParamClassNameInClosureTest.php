<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\Query;
use Kiyonori\ElasticsearchFluentQueryBuilder\GetFistParamClassNameInClosure;

test(
    'GetFistParamClassNameInClosure を使うことで、クロージャの第一引数の型を判別できること stdClass',

    /**
     * @throws ReflectionException
     */
    function () {
        /** @var GetFistParamClassNameInClosure $getFistParamClassNameInClosure */
        $getFistParamClassNameInClosure = app(GetFistParamClassNameInClosure::class);

        $className = $getFistParamClassNameInClosure->execute(
            function (stdClass $stdClass) {}
        );

        expect($className)
            ->toBe(stdClass::class);
    }
);

test(
    'GetFistParamClassNameInClosure を使うことで、クロージャの第一引数の型を判別できること Query',

    /**
     * @throws ReflectionException
     */
    function () {
        /** @var GetFistParamClassNameInClosure $getFistParamClassNameInClosure */
        $getFistParamClassNameInClosure = app(GetFistParamClassNameInClosure::class);

        $className = $getFistParamClassNameInClosure->execute(
            function (Query $queryInstance) {}
        );

        expect($className)
            ->toBe(Query::class);
    }
);

test(
    'GetFistParamClassNameInClosure を使うことで、クロージャに引数がまったくない場合 null が返ってくること',
    function () {
        /** @var GetFistParamClassNameInClosure $getFistParamClassNameInClosure */
        $getFistParamClassNameInClosure = app(GetFistParamClassNameInClosure::class);

        $className = $getFistParamClassNameInClosure->execute(
            function () {}
        );

        expect($className)
            ->toBeNull();
    }
);

test(
    'GetFistParamClassNameInClosure を使うことで、クロージャに複数の引数がある場合 null が返ってくること',
    function () {
        /** @var GetFistParamClassNameInClosure $getFistParamClassNameInClosure */
        $getFistParamClassNameInClosure = app(GetFistParamClassNameInClosure::class);

        $className = $getFistParamClassNameInClosure->execute(
            function (stdClass $stdClass, Query $query) {}
        );

        expect($className)
            ->toBeNull();
    }
);
