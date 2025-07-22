<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Values\StaticStd;

test(
    'stdClass が作られること',
    function () {
        expect(StaticStd::instance())->toBeInstanceOf(
            stdClass::class,
        );
    }
);
