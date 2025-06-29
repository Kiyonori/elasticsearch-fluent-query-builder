<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;

final readonly class StoreDocument
{
    /**
     * Elasticsearch の所定のインデックス内にドキュメントを1件登録
     *
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function execute(
        string $indexName,
        string $documentId,
        array $body,
    ): Elasticsearch {
        /** @var Client $client */
        $client = app(PrepareElasticsearchClient::class)
            ->execute();

        return $client->index([
            'index' => $indexName,
            'id'    => $documentId,
            'body'  => $body,
        ]);
    }
}
