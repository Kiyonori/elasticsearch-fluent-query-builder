<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\ApplyMapping;
use Kiyonori\ElasticsearchFluentQueryBuilder\CheckIndexExists;
use Kiyonori\ElasticsearchFluentQueryBuilder\DeleteIndex;

beforeEach(
    function () {
        app(DeleteIndex::class)->execute(
            indexName: 'chat_histories',
            suppressNotFoundException: true,
        );
    }
);

afterEach(
    function () {
        app(DeleteIndex::class)->execute(
            indexName: 'chat_histories',
            suppressNotFoundException: true,
        );
    }
);

test(
    'JSON ファイルからElasticsearchに事前にマッピングできること',
    function () {
        expect(
            app(CheckIndexExists::class)->execute(
                indexName: 'chat_histories'
            )
        )->toBeFalse();

        $newIndexName = app(ApplyMapping::class)->execute(
            jsonFilePath: realpath(__DIR__ . '/storages/explicit_mapping/chat_histories.json'),
        );

        expect($newIndexName)
            ->toStartWith('chat_histories_')
            ->and(
                app(CheckIndexExists::class)->execute(
                    indexName: 'chat_histories'
                )
            )->toBeTrue();
    }
);
