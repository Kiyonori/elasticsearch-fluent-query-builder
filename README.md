# Elasticsearch Fluent Query Builder

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/badge/php-%5E8.2-blue.svg)](https://www.php.net/)
[![Elasticsearch](https://img.shields.io/badge/Elasticsearch-%5E8.17-orange.svg)](https://www.elastic.co/)

Elasticsearchのクエリビルダーとインデックス・ドキュメント操作機能を提供するPHPライブラリです。フルエントAPIを使用してElasticsearchクエリを直感的に構築できます。

## 特徴

- **フルエントAPI**:
  - メソッドチェーンで Elasticsearch クエリを直感的に構築
- **型安全**:
  - PHP 8.2+の型システムを活用した安全な API
- **包括的なクエリサポート**:
  - `must`, `should`, `filter`, `must_not` クエリをサポート
- **インデックス管理**:
  - マッピングの適用、インデックスの削除、エイリアス管理
- **ドキュメント操作**:
  - ドキュメントの保存、取得、更新、一括操作

## 要件

- PHP 8.2以上
- Elasticsearch 8.17以上

## インストール

```bash
composer require kiyonori/elasticsearch-fluent-query-builder
```

## 使用方法

### クエリビルダー

#### 基本的なboolクエリ

```php
use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\Query;
use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\MustQuery;
use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\ShouldQuery;

$query = app(Query::class);

$result = $query
    ->bool(function (MustQuery $must) {
        $must
            ->bool(function (ShouldQuery $should) {
                $should
                    ->match('title', 'elasticsearch')
                    ->match('content', 'search engine');
            }, minimumShouldMatch: 1)
            ->term('status', 'published')
            ->range('created_at', gte: '2024-01-01', lte: '2024-12-31');
    })
    ->toArray();
```

#### 複雑なネストしたクエリ

```php
$query = app(Query::class);

$result = $query
    ->bool(function (MustQuery $must) {
        $must
            ->bool(function (ShouldQuery $should) {
                $should
                    ->match('field_1', 'value1')
                    ->match('field_2', 'value 2');
            }, minimumShouldMatch: 1)
            ->bool(function (ShouldQuery $should) {
                $should
                    ->match('field_3', 'value 333')
                    ->match('field_4', 'value四')
                    ->match('field_5', 'value５');
            }, minimumShouldMatch: 2);
    })
    ->toArray();
```

#### 利用可能なクエリタイプ

**MustQuery** - 必須条件:

```php
$must
    ->term('field', 'value')
    ->match('field', 'text')
    ->range('field', gte: 10, lte: 100)
    ->bool(function (ShouldQuery $should) { /* ... */ });
```

**ShouldQuery** - 任意条件:

```php
$should
    ->term('field', 'value')
    ->match('field', 'text')
    ->range('field', gte: 10, lte: 100)
    ->bool(function (MustQuery $must) { /* ... */ });
```

**FilterQuery** - フィルター条件:

```php
$filter
    ->term('field', 'value')
    ->match('field', 'text')
    ->range('field', gte: 10, lte: 100);
```

**MustNotQuery** - 除外条件:

```php
$mustNot
    ->term('field', 'value')
    ->match('field', 'text')
    ->range('field', gte: 10, lte: 100);
```

### インデックスとドキュメント操作

#### マッピングの適用

```php
use Kiyonori\ElasticsearchFluentQueryBuilder\ApplyMapping;

// JSONファイルからマッピングを適用（エイリアス付きでゼロダウンタイム）
$newIndexName = app(ApplyMapping::class)->execute(
    jsonFilePath: 'path/to/mapping.json'
);
```

#### ドキュメントの保存

```php
use Kiyonori\ElasticsearchFluentQueryBuilder\StoreDocument;

$response = app(StoreDocument::class)->execute(
    indexName: 'my_index',
    documentId: 'doc_123',
    body: [
        'title' => 'Sample Document',
        'content' => 'This is a sample document',
        'created_at' => '2024-01-01T00:00:00Z'
    ]
);
```

#### ドキュメントの取得

```php
use Kiyonori\ElasticsearchFluentQueryBuilder\GetDocument;

$document = app(GetDocument::class)->execute(
    indexName: 'my_index',
    documentId: 'doc_123'
);
```

#### インデックスの削除

```php
use Kiyonori\ElasticsearchFluentQueryBuilder\DeleteIndex;

$deletedIndices = app(DeleteIndex::class)->execute(
    indexName: 'my_index',
    suppressNotFoundException: true
);
```

#### 一括ドキュメント操作

```php
use Kiyonori\ElasticsearchFluentQueryBuilder\BulkStoreDocuments;

$response = app(BulkStoreDocuments::class)->execute(
    indexName: 'my_index',
    documents: [
        ['id' => 'doc_1', 'body' => ['title' => 'Document 1']],
        ['id' => 'doc_2', 'body' => ['title' => 'Document 2']],
    ]
);
```

## 設定ファイルの例

`config/my-elasticsearch.php`:

```php
<?php

return [
    'hosts' => [
        'http://elasticsearch:9200',
    ],
    'ssl_verification' => false,
    'user_name'        => null,
    'password'         => null,
];
```

## マッピングJSONファイルの例

```json
{
    "index": "my_index",
    "body": {
        "mappings": {
            "properties": {
                "title": {
                    "type": "text",
                    "analyzer": "standard"
                },
                "content": {
                    "type": "text",
                    "analyzer": "standard"
                },
                "created_at": {
                    "type": "date"
                }
            }
        }
    }
}
```

## テスト

```bash
# テストの実行
make test
```

## 開発環境の構築

このリポジトリには Docker と Makefile が用意されています。以下の手順で最短で立ち上げられます。

### 1. 前提

- docker コマンドが利用可能であること
- make コマンドが利用可能であること

### 2. 初回セットアップと起動

```bash
make up
```

- 初回は `.env` を自動生成します
- 起動後、Elasticsearch は `http://localhost:${ELASTICSEARCH_OUTWARD_PORT}` で待ち受けます
- デフォルトポートは `.env` で指定します（例: `ELASTICSEARCH_OUTWARD_PORT=9200`）

### 3. 設定ファイル

接続先は `config/my-elasticsearch.php` で管理します

```php
<?php

return [
    'hosts' => [
        'http://elasticsearch:9200',
    ],
    'ssl_verification' => false,
    'user_name'        => null,
    'password'         => null,
];
```

- `hosts` はコンテナ間通信用のホスト名 `elasticsearch` を利用します
- ホストOSから疎通確認する場合は `http://localhost:9200` を利用します

### 4. 接続確認

```bash
curl -s http://localhost:9200/ | jq .
```

```json
{
  "name": "9fe5729c9607",
  "cluster_name": "docker-cluster",
  "cluster_uuid": "CRxG1rjBSICWjzoTxh-EWQ",
  "version": {
    "number": "8.18.0",
    "build_flavor": "default",
    "build_type": "docker",
    "build_hash": "04e979aa50b657bebd4a0937389308de82c2bdad",
    "build_date": "2025-04-10T10:09:16.444104780Z",
    "build_snapshot": false,
    "lucene_version": "9.12.1",
    "minimum_wire_compatibility_version": "7.17.0",
    "minimum_index_compatibility_version": "7.0.0"
  },
  "tagline": "You Know, for Search"
}
```

上記の JSON が返れば OK です

### 5. テスト / コード整形の実行

```bash
# テスト
make test

# コード整形
make pint
```

### 6. 開発環境の停止・再起動・クリーンアップ

## ライセンス

このプロジェクトはMITライセンスの下で公開されています。詳細は[LICENSE](LICENSE)ファイルを参照してください。

## 作者

- Kiyonori SAKAI

## 貢献

プルリクエストやイシューの報告を歓迎します。
