<?php


namespace Tests\Builders;

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\FluentQueryBuilder;
use Kiyonori\ElasticsearchFluentQueryBuilder\Values\Nothing;
use PHPUnit\Framework\TestCase;
use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\Builder;

class FluentQueryBuilderTest extends TestCase
{
    public function test_must_検索条件を含めて_toArray_メソッドを呼んだ場合、意図したクエリの形が組み立てられること()
    {
        $searchQuery = new FluentQueryBuilder;

        $result = $searchQuery
            ->must(function (Builder $must) {
                $must
                    ->term('chat_id', 'u968edd043c46262efe69ef21ad458c6d')
                    ->term('type', 1)
                    ->match('content', 'おはよう')
                    ->match('content', '今度')
                    ->range(
                        fieldName: 'created_time',
                        gte: 1736925752798,
                        lte: Nothing::make(),
                    )
                    ->range('id', 333, 555);
            })
            ->size(10)
            ->searchAfter(12345)
            ->sort('created_time', 'desc')
            ->sort('id', 'desc')
            ->toArray();

        $this->assertSame(
            expected: [
                'body' => [
                    'query'        => [
                        'bool' => [
                            'must' => [
                                [
                                    'term' => [
                                        'chat_id' => 'u968edd043c46262efe69ef21ad458c6d',
                                    ],
                                ],
                                [
                                    'term' => [
                                        'type' => 1,
                                    ],
                                ],
                                [
                                    'match' => [
                                        'content' => 'おはよう',
                                    ],
                                ],
                                [
                                    'match' => [
                                        'content' => '今度',
                                    ],
                                ],
                                [
                                    'range' => [
                                        'created_time' => [
                                            'gte' => 1736925752798,
                                        ],
                                    ],
                                ],
                                [
                                    'range' => [
                                        'id' => [
                                            'gte' => 333,
                                            'lte' => 555,
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'size'         => 10,
                    'search_after' => [
                        12345,
                    ],
                    'sort'         => [
                        [
                            'created_time' => [
                                'order' => 'desc',
                            ],
                        ],
                        [
                            'id' => [
                                'order' => 'desc',
                            ],
                        ],
                    ],
                ],
            ],
            actual: $result,
        );
    }
}
