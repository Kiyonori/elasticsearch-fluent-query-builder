<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder;

use Illuminate\Support\ServiceProvider;

class ElasticsearchServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/../config/my-elasticsearch.php' => config_path('my-elasticsearch.php'),
            ],
            'my-elasticsearch'
        );
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/my-elasticsearch.php',
            'my-elasticsearch'
        );
    }
}
