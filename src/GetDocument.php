<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

final readonly class GetDocument
{
    /**
     * Elasticsearch からドキュメントを1件取得する
     *
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function execute(
        string $indexName,
        string $documentId,
    ): array {
        /** @var Client $client */
        $client = app(PrepareElasticsearchClient::class)
            ->execute();

        return $client
            ->get([
                'index' => $indexName,
                'id'    => $documentId,
            ])->asArray();
    }
}
