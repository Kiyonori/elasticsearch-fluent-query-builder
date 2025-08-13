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
