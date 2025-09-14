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
