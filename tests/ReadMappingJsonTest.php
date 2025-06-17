<?php

namespace Tests;

use Kiyonori\ElasticsearchFluentQueryBuilder\Data\Mapping\JsonData;
use Kiyonori\ElasticsearchFluentQueryBuilder\ReadMappingJson;
use PHPUnit\Framework\TestCase;

class ReadMappingJsonTest extends TestCase
{
    public function test_ReadMappingJson_で読み込んだJSONファイルがData_Transfer_Objectとして返ってくること()
    {
        $jsonFilePath = realpath(__DIR__ . '/storages/explicit_mapping/chat_histories.json');

        $result = (new ReadMappingJson)->execute(
            $jsonFilePath,
        );

        $this->assertInstanceOf(
            JsonData::class,
            $result,
        );
    }
}
