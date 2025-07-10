<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;

final readonly class BulkStoreDocuments
{
    /**
     * Elasticsearch に一括でドキュメントを登録する
     *
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function execute(
        string $indexName,
        array $items,
        ?string $idColumnName = null,
    ): Elasticsearch {
        /** @var Client $client */
        $client = app(PrepareElasticsearchClient::class)
            ->execute();

        $params = [];

        foreach ($items as $item) {
            $param['_index'] = $indexName;

            if ($idColumnName !== null) {
                $param['_id'] = (string) $item[$idColumnName];
            }

            $params['body'][] = [
                'index' => $param,
            ];

            $params['body'][] = $item;
        }

        return $client->bulk($params);
    }
}
