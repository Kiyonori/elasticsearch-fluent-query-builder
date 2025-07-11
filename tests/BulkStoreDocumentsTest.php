<?php

use Elastic\Elasticsearch\Response\Elasticsearch;
use Kiyonori\ElasticsearchFluentQueryBuilder\ApplyMapping;
use Kiyonori\ElasticsearchFluentQueryBuilder\BulkStoreDocuments;
use PHPUnit\Framework\TestCase;

class BulkStoreDocumentsTest extends TestCase
{
    public function test_Elasticsearch_に一括でドキュメントを登録できること()
    {
        $rowItem = [
            'chat_id' => 'u968ed404bc4626333e69ef21ad455a5d',
            'content' => 'おはようございます☀️今日もよろしくおねがいします🚲️',
        ];

        $items = [];

        for ($i = 0; $i < 100; $i++) {
            $items[]         = $rowItem;
            $items[$i]['id'] = $i + 1;
        }

        // テストには直接影響しないが、フィールドのマッピング定義を登録しておく
        app(ApplyMapping::class)->execute(
            jsonFilePath: realpath(__DIR__ . '/storages/explicit_mapping/users.json'),
        );

        // テスト対象のサービスクラスを実行
        /** @var Elasticsearch $response */
        $response = app(BulkStoreDocuments::class)
            ->execute(
                indexName: 'users',
                items: $items,
                idColumnName: 'id',
            );

        $this->assertSame(
            expected: 200,
            actual: $response->getStatusCode()
        );
    }
}
