<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder\Values;

use stdClass;

final class StaticStd
{
    private static stdClass $instance;

    public static function instance(): stdClass
    {
        if (! isset(self::$instance)) {
            self::$instance = app(stdClass::class);
        }

        return self::$instance;
    }
}
