<?php

namespace Tests;

use Kiyonori\ElasticsearchFluentQueryBuilder\ApplyMapping;
use PHPUnit\Framework\TestCase;

class ApplyMappingTest extends TestCase
{
    public function test_JSON_ファイルからElasticsearchに事前にマッピングできること()
    {
        $jsonFilePath = realpath(__DIR__ . '/storages/explicit_mapping/chat_histories.json');

        $newIndexName = app(ApplyMapping::class)->execute(
            $jsonFilePath
        );

        $this->assertTrue(
            gettype($newIndexName) === 'string'
        );
    }
}
