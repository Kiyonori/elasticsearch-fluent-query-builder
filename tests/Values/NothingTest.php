<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Values\Nothing;

test(
    'Nothing という Value Object が作られること',
    function () {
        expect(new Nothing)->toBeInstanceOf(
            Nothing::class,
        );
    }
);
