<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

final readonly class GetConcreteIndexNames
{
    /**
     * Elasticsearch 内の実際のインデックス名を取得する
     *
     * @param  string  $aliasIndexName  エイリアスとしてのインデックス名
     * @return string[] 実際のインデックス名 (複数ありうるので array です)
     *
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function execute(
        Client $client,
        string $aliasIndexName,
        bool $suppressNotFoundException = false,
    ): array {
        try {
            $response = $client
                ->indices()
                ->getAlias(['name' => $aliasIndexName]);

        } catch (ClientResponseException $exception) {
            if ($exception->getCode() === 404
                && $suppressNotFoundException
            ) {
                return [];
            }

            throw $exception;
        }

        return array_keys(
            $response->asArray()
        );
    }
}
