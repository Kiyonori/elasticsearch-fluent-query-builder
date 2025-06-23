<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder;

use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

final readonly class CheckIndexExists
{
    /**
     * Elasticsearch に指定したインデックス名が存在するかどうかを調べる
     *
     * @return bool true: 存在する, false: 存在しない
     *
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function execute(
        string $indexName,
    ): bool {
        $client = (new PrepareElasticsearchClient)
            ->execute();

        return $client
            ->indices()
            ->exists(['index' => $indexName])
            ->asBool();
    }
}
