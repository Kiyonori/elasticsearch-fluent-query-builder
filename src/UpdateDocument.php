<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;

final readonly class UpdateDocument
{
    /**
     * Elasticsearch のドキュメント内の一部分の値を更新する
     *
     * @param  string  $indexName  ドキュメント名
     * @param  string  $documentId  ドキュメントのID
     * @param  array  $diff  更新箇所の key-value
     *
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function execute(
        string $indexName,
        string $documentId,
        array $diff,
    ): Elasticsearch {
        /** @var Client $client */
        $client = app(PrepareElasticsearchClient::class)
            ->execute();

        return $client->update([
            'index' => $indexName,
            'id'    => $documentId,
            'body'  => [
                'doc' => $diff,
            ],
        ]);
    }
}
