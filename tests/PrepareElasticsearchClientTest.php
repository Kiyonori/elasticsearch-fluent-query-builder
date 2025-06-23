<?php

namespace Tests;

use Elastic\Elasticsearch\Exception\AuthenticationException;
use Kiyonori\ElasticsearchFluentQueryBuilder\PrepareElasticsearchClient;
use PHPUnit\Framework\TestCase;

class PrepareElasticsearchClientTest extends TestCase
{
    /**
     * @throws AuthenticationException
     */
    public function test_PrepareElasticsearchClient_で作られる_client_はシングルトンであること()
    {
        $client1 = new PrepareElasticsearchClient()
            ->execute();

        $client2 = new PrepareElasticsearchClient()
            ->execute();

        $this->assertSame(
            expected: $client1,
            actual: $client2,
        );
    }
}
