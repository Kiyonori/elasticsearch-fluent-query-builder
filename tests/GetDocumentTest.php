<?php

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Kiyonori\ElasticsearchFluentQueryBuilder\ApplyMapping;
use Kiyonori\ElasticsearchFluentQueryBuilder\DeleteIndex;
use Kiyonori\ElasticsearchFluentQueryBuilder\GetDocument;
use Kiyonori\ElasticsearchFluentQueryBuilder\StoreDocument;
use PHPUnit\Framework\TestCase;

class GetDocumentTest extends TestCase
{
    protected function setUp(): void
    {
        // テスト開始前にインデックスを削除する
        app(DeleteIndex::class)
            ->execute(
                indexName: 'chat_histories',
                suppressNotFoundException: true,
            );

        // chat_histories というインデックスを作成する
        app(ApplyMapping::class)->execute(
            jsonFilePath: realpath(__DIR__ . '/storages/explicit_mapping/chat_histories.json')
        );
    }

    public function test_Elasticsearch_から_id_を指定してドキュメントが取得できること()
    {
        app(StoreDocument::class)->execute(
            indexName: 'chat_histories',
            documentId: '123123',
            body: [
                'pk'                       => 42458,
                'id'                       => 42878,
                'server_id'                => 5562410123063324,
                'type'                     => 1,
                'chat_id'                  => 'u968ed404bc4626333e69ef21ad455a5d',
                'from_mid'                 => null,
                'content'                  => 'おはようございます☀️今日もよろしくおねがいします🚲️',
                'created_time'             => 1744376788463,
                'delivered_time'           => 0,
                'status'                   => 3,
                'sent_count'               => null,
                'read_count'               => null,
                'location_name'            => null,
                'location_address'         => null,
                'location_phone'           => null,
                'location_latitude'        => null,
                'location_longitude'       => null,
                'attachement_image'        => 0,
                'attachement_image_height' => null,
                'attachement_image_width'  => null,
                'attachement_image_size'   => null,
                'attachement_type'         => 0,
                'attachement_local_uri'    => null,
                'parameter'                => 'dummy_params',
                'created_at'               => '2025-04-27T21:03:47+0900',
                'updated_at'               => '2025-04-27T21:03:47+0900',
                'deleted_at'               => null,
            ],
        );

        $result = app(GetDocument::class)->execute(
            indexName: 'chat_histories',
            documentId: '123123',
        );

        $this->assertSame(
            expected: '123123',
            actual: $result['_id']
        );
    }

    public function test_Elasticsearch_から_id_を指定してドキュメントを取得する歳、指定した_ID_のドキュメントが見つからない場合、404が返ってくること()
    {
        app(StoreDocument::class)->execute(
            indexName: 'chat_histories',
            documentId: '123123',
            body: [
                'pk'                       => 42458,
                'id'                       => 42878,
                'server_id'                => 5562410123063324,
                'type'                     => 1,
                'chat_id'                  => 'u968ed404bc4626333e69ef21ad455a5d',
                'from_mid'                 => null,
                'content'                  => 'おはようございます☀️今日もよろしくおねがいします🚲️',
                'created_time'             => 1744376788463,
                'delivered_time'           => 0,
                'status'                   => 3,
                'sent_count'               => null,
                'read_count'               => null,
                'location_name'            => null,
                'location_address'         => null,
                'location_phone'           => null,
                'location_latitude'        => null,
                'location_longitude'       => null,
                'attachement_image'        => 0,
                'attachement_image_height' => null,
                'attachement_image_width'  => null,
                'attachement_image_size'   => null,
                'attachement_type'         => 0,
                'attachement_local_uri'    => null,
                'parameter'                => 'dummy_params',
                'created_at'               => '2025-04-27T21:03:47+0900',
                'updated_at'               => '2025-04-27T21:03:47+0900',
                'deleted_at'               => null,
            ],
        );

        $this->expectException(ClientResponseException::class);
        $this->expectExceptionCode(404);

        app(GetDocument::class)->execute(
            indexName: 'chat_histories',
            documentId: '99999',
        );
    }
}
