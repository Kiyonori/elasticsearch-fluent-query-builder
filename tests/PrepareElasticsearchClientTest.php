<?php

use Elastic\Elasticsearch\Exception\AuthenticationException;
use Kiyonori\ElasticsearchFluentQueryBuilder\PrepareElasticsearchClient;

test(
    'PrepareElasticsearchClient で作られる client はシングルトンであること',
    /**
     * @throws AuthenticationException
     */
    function () {
        $client1 = (new PrepareElasticsearchClient)
            ->execute();

        $client2 = (new PrepareElasticsearchClient)
            ->execute();

        expect($client1)
            ->toBe($client2);
    }
);
