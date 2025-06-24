<?php

namespace Kiyonori\ElasticsearchFluentQueryBuilder;

use Kiyonori\ElasticsearchFluentQueryBuilder\Data\Mapping\JsonData;

final readonly class ReadMappingJson
{
    /**
     * Explicit Mapping 用の JSON ファイルを読み込み、そのファイル内容を Data Transfer Object として返す
     */
    public function execute(
        string $jsonFilePath
    ): JsonData {
        /** @var string $contents */
        $contents = file_get_contents($jsonFilePath);

        $mappings = json_decode(
            json: $contents,
            associative: true,
        );

        return app(
            JsonData::class,
            $mappings['index'],
            $mappings['body'],
        );
    }
}