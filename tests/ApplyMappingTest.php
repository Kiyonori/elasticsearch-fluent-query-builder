<?php

namespace Tests;

use Kiyonori\ElasticsearchFluentQueryBuilder\ApplyMapping;
use Kiyonori\ElasticsearchFluentQueryBuilder\CheckIndexExists;
use Kiyonori\ElasticsearchFluentQueryBuilder\DeleteIndex;
use PHPUnit\Framework\TestCase;

class ApplyMappingTest extends TestCase
{
    protected function setUp(): void
    {
        app(DeleteIndex::class)->execute(
            indexName: 'chat_histories',
            suppressNotFoundException: true,
        );
    }

    protected function tearDown(): void
    {
        app(DeleteIndex::class)->execute(
            indexName: 'chat_histories',
            suppressNotFoundException: true,
        );
    }

    public function test_JSON_ファイルからElasticsearchに事前にマッピングできること()
    {
        $this->assertFalse(
            app(CheckIndexExists::class)->execute(
                indexName: 'chat_histories'
            )
        );

        $newIndexName = app(ApplyMapping::class)->execute(
            jsonFilePath: realpath(__DIR__ . '/storages/explicit_mapping/chat_histories.json'),
        );

        $this->assertStringStartsWith(
            prefix: 'chat_histories_',
            string: $newIndexName,
        );

        $this->assertTrue(
            app(CheckIndexExists::class)->execute(
                indexName: 'chat_histories'
            )
        );
    }
}
