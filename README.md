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
