<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Data\Mapping\JsonData;
use Kiyonori\ElasticsearchFluentQueryBuilder\ReadMappingJson;

test(
    'ReadMappingJson で読み込んだJSONファイルがData Transfer Objectとして返ってくること',
    function () {
        $jsonFilePath = realpath(__DIR__ . '/storages/explicit_mapping/chat_histories.json');

        $result = (new ReadMappingJson)->execute(
            $jsonFilePath,
        );

        expect($result)
            ->toBeInstanceOf(JsonData::class);
    }
);
