<?php

use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Kiyonori\ElasticsearchFluentQueryBuilder\ApplyMapping;
use Kiyonori\ElasticsearchFluentQueryBuilder\CheckIndexExists;
use Kiyonori\ElasticsearchFluentQueryBuilder\DeleteIndex;
use PHPUnit\Framework\TestCase;

class DeleteIndexTest extends TestCase
{
    /**
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function test_Elasticsearch_からインデックスが削除できること()
    {
        // テスト開始前にインデックスを削除する
        app(DeleteIndex::class)
            ->execute(
                indexName: 'chat_histories',
                suppressNotFoundException: true,
            );

        // インデックスが存在しないことを確認する
        $this->assertFalse(
            condition: app(CheckIndexExists::class)->execute(
                indexName: 'chat_histories',
            )
        );
        
        // chat_histories というインデックスを作成する
        app(ApplyMapping::class)->execute(
            jsonFilePath: realpath(__DIR__ . '/storages/explicit_mapping/chat_histories.json'),
        );

        // chat_histories というインデックスが作成されていることを確認する
        $this->assertTrue(
            condition: app(CheckIndexExists::class)->execute(
                indexName: 'chat_histories',
            )
        );
        // chat_histories というインデックスを削除する
        app(DeleteIndex::class)
            ->execute(
                indexName: 'chat_histories',
                suppressNotFoundException: true,
            );

        // chat_histories というインデックスが存在しないことを確認する
        $this->assertFalse(
            condition: app(CheckIndexExists::class)->execute(
                indexName: 'chat_histories',
            )
        );
    }
}
