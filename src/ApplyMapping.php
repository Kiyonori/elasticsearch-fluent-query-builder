<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

final readonly class ApplyMapping
{
    /**
     * 事前に定義済みの JSON ファイルから Elasticsearch のマッピング（エイリアス付きでゼロダウンタイム）を登録する
     *
     * @param  string  $jsonFilePath  拡張子を含む JSON ファイルの Path
     * @return string 新しい実インデックス名
     *
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function execute(
        string $jsonFilePath,
    ): string {
        /** @var string[] $mapping */
        $mapping = json_decode(
            json: file_get_contents($jsonFilePath),
            associative: true,
        );

        //var_dump($mapping);
        //exit;

        /** @var Client $client */
        $client = app(PrepareElasticsearchClient::class)
            ->execute();

        $newIndexName = sprintf(
            '%s_%s',
            $mapping['index'],
            now()->format('YmdHis'),
        );

        $client
            ->indices()
            ->create([
                'index' => $newIndexName,
                'body'  => $mapping['body'],
            ]);

        /** @var string[] $concreteIndices 実際のインデックス名 (複数ありうるので array です) */
        $concreteIndices = app(GetConcreteIndexNames::class)
            ->execute(
                aliasIndexName: $mapping['index'],
                suppressNotFoundException: true,
            );

        if (empty($concreteIndices)) {
            $client->indices()->putAlias([
                'index' => $newIndexName,
                'name'  => $mapping['index'],
            ]);
        }

        foreach ($concreteIndices as $oldIndex) {
            $client->indices()->updateAliases([
                'body' => [
                    'actions' => [
                        [
                            'remove' => [
                                'index' => $oldIndex,
                                'alias' => $mapping['index'],
                            ],
                        ],
                        [
                            'add' => [
                                'index' => $newIndexName,
                                'alias' => $mapping['index'],
                            ],
                        ],
                    ],
                ],
            ]);
        }

        return $newIndexName;
    }
}
