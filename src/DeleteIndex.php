<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

final readonly class DeleteIndex
{
    /**
     * Elasticsearch からインデックスを削除する
     *
     * @param  string  $indexName  削除対象のインデックス名
     * @return string[] 削除した実インデックス名
     *
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function execute(
        string $indexName,
        bool $suppressNotFoundException = false,
    ): array {
        /** @var Client $client */
        $client = app(PrepareElasticsearchClient::class)
            ->execute();

        try {
            /** @var string[] $concreteIndices 実際のインデックス名 (複数ありうるので array です) */
            $concreteIndices = app(GetConcreteIndexNames::class)
                ->execute($indexName);
        } catch (ClientResponseException $exception) {
            if ($exception->getCode() === 404
                && $suppressNotFoundException
            ) {
                return [];
            }

            throw $exception;
        }

        foreach ($concreteIndices as $concreteIndex) {
            $client
                ->indices()
                ->delete(['index' => $concreteIndex]);
        }

        return $concreteIndices;
    }
}
