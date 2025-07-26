<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\ApplyMapping;
use Kiyonori\ElasticsearchFluentQueryBuilder\CheckIndexExists;
use Kiyonori\ElasticsearchFluentQueryBuilder\DeleteIndex;

test(
    'Elasticsearch からインデックスが削除できること',
    function () {
        // テスト開始前にインデックスを削除する
        app(DeleteIndex::class)
            ->execute(
                indexName: 'chat_histories',
                suppressNotFoundException: true,
            );

        // インデックスが存在しないことを確認する
        expect(
            app(CheckIndexExists::class)->execute(
                indexName: 'chat_histories',
            )
        )->toBeFalse();

        // chat_histories というインデックスを作成する
        app(ApplyMapping::class)->execute(
            jsonFilePath: realpath(__DIR__ . '/storages/explicit_mapping/chat_histories.json'),
        );

        // chat_histories というインデックスが作成されていることを確認する
        expect(
            app(CheckIndexExists::class)->execute(
                indexName: 'chat_histories',
            )
        )->toBeTrue();

        // chat_histories というインデックスを削除する
        app(DeleteIndex::class)
            ->execute(
                indexName: 'chat_histories',
                suppressNotFoundException: true,
            );

        // chat_histories というインデックスが存在しないことを確認する
        expect(
            app(CheckIndexExists::class)->execute(
                indexName: 'chat_histories',
            )
        )->toBeFalse();
    }
);
