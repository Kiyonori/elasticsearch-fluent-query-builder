<?php

use Elastic\Elasticsearch\Response\Elasticsearch;
use Kiyonori\ElasticsearchFluentQueryBuilder\ApplyMapping;
use Kiyonori\ElasticsearchFluentQueryBuilder\BulkStoreDocuments;

class BulkStoreDocumentsTest extends \PHPUnit\Framework\TestCase
{
    public function test_Elasticsearch_に一括でドキュメントを登録できること()
    {
        $rowItem = [
            // 'pk'                    => 42458,
            // 'id'                    => 42878,
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
        ];

        $items = [];

        for ($i = 0; $i < 100; $i++) {
            $items[]         = $rowItem;
            $items[$i]['id'] = $i + 1;
            $items[$i]['pk'] = $i + 1;
        }

        // テストには直接影響しないが、フィールドのマッピング定義を登録しておく
        app(ApplyMapping::class)->execute(
            jsonFilePath: realpath(__DIR__ . '/storages/explicit_mapping/chat_histories.json'),
        );

        // テスト対象のサービスクラスを実行
        /** @var Elasticsearch $response */
        $response = app(BulkStoreDocuments::class)
            ->execute(
                indexName: 'chat_histories',
                items: $items,
                idColumnName: 'id',
            );

        $this->assertSame(
            expected: 200,
            actual: $response->getStatusCode()
        );
    }
}
