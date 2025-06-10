<?php


namespace Tests\Builders;

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\FluentQueryBuilder;
use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\Highlight;
use Kiyonori\ElasticsearchFluentQueryBuilder\Values\Nothing;
use Kiyonori\ElasticsearchFluentQueryBuilder\Values\StaticStd;
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

    public function test_filter_検索条件を含めて_toArray_メソッドを呼んだ場合、意図したクエリの形が組み立てられること()
    {
        $searchQuery = new FluentQueryBuilder;

        $result = $searchQuery
            ->filter(function (Builder $filter) {
                $filter
                    ->term('chat_id', 'u968edd043c46262efe69ef21ad458c6d')
                    ->term('type', 1)
                    ->match('content', 'おはよう')
                    ->match('content', '今度は')
                    ->range(
                        'created_time',
                        1777777777777,
                        1888888888888,
                    );
            })
            ->toArray();

        $this->assertSame(
            expected: [
                'body' => [
                    'query' => [
                        'bool' => [
                            'filter' => [
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
                                        'content' => '今度は',
                                    ],
                                ],
                                [
                                    'range' => [
                                        'created_time' => [
                                            'gte' => 1777777777777,
                                            'lte' => 1888888888888,
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            actual: $result,
        );
    }

    public function test_must_not_検索条件を含めて_toArray_メソッドを呼んだ場合、意図したクエリの形が組み立てられること()
    {
        $searchQuery = new FluentQueryBuilder;

        $result = $searchQuery
            ->mustNot(function (Builder $mustNot) {
                $mustNot
                    ->term('chat_id', 'u968edd043c46262efe69ef21ad458c6d')
                    ->term('type', 1)
                    ->match('content', 'おはよう')
                    ->match('content', '今度は')
                    ->range(
                        'created_time',
                        1777777777777,
                        1888888888888,
                    );
            })
            ->toArray();

        $this->assertSame(
            expected: [
                'body' => [
                    'query' => [
                        'bool' => [
                            'must_not' => [
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
                                        'content' => '今度は',
                                    ],
                                ],
                                [
                                    'range' => [
                                        'created_time' => [
                                            'gte' => 1777777777777,
                                            'lte' => 1888888888888,
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            actual: $result,
        );
    }

    public function test_highlight_検索条件を含めて_toArray_メソッドを呼んだ場合、意図したクエリの形が組み立てられること()
    {
        $searchQuery = new FluentQueryBuilder;

        $result = $searchQuery
            ->highlight(function (Highlight $highlightField) {
                $highlightField->fields('content');
            })
            ->toArray();

        $this->assertSame(
            expected: [
                'body' => [
                    'highlight' => [
                        'fields' => [
                            'content' => StaticStd::instance(),
                        ],
                    ],
                ],
            ],
            actual: $result,
        );

        $result = $searchQuery
            ->highlight(
                fn(Highlight $highlightField) => $highlightField
                    ->fields(
                        fieldName: 'content',
                        fragmentSize: 150,
                        numberOfFragments: 3,
                    ),
            )
            ->toArray();

        $this->assertSame(
            expected: [
                'body' => [
                    'highlight' => [
                        'fields' => [
                            'content' => [
                                'fragment_size'       => 150,
                                'number_of_fragments' => 3,
                            ],
                        ],
                    ],
                ],
            ],
            actual: $result,
        );

        $result = $searchQuery
            ->highlight(
                fn(Highlight $highlightField) => $highlightField
                    ->fields(
                        fieldName: 'content',
                        fragmentSize: 150,
                        numberOfFragments: 3,
                    ),
                preTags: ['<em>'],
                postTags: ['</em>'],
            )
            ->toArray();

        $this->assertSame(
            expected: [
                'body' => [
                    'highlight' => [
                        'pre_tags'  => ['<em>'],
                        'post_tags' => ['</em>'],
                        'fields'    => [
                            'content' => [
                                'fragment_size'       => 150,
                                'number_of_fragments' => 3,
                            ],
                        ],
                    ],
                ],
            ],
            actual: $result,
        );

        $result = $searchQuery
            ->filter(function (Builder $filter) {
                $filter
                    ->term('chat_id', 'u968edd043c46262efe69ef21ad458c6d')
                    ->term('type', 1)
                    ->match('content', 'おはよう')
                    ->match('content', '今度は')
                    ->range(
                        'created_time',
                        1777777777777,
                        1888888888888,
                    );
            })
            ->highlight(
                fn(Highlight $highlightField) => $highlightField
                    ->fields(
                        fieldName: 'content',
                        fragmentSize: 150,
                        numberOfFragments: 3,
                    )
                    ->fields(
                        fieldName: 'chat_id',
                    ),
            )
            ->toArray();

        $this->assertSame(
            expected: [
                'body' => [
                    'query'     => [
                        'bool' => [
                            'filter' => [
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
                                        'content' => '今度は',
                                    ],
                                ],
                                [
                                    'range' => [
                                        'created_time' => [
                                            'gte' => 1777777777777,
                                            'lte' => 1888888888888,
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'highlight' => [
                        'fields' => [
                            'content' => [
                                'fragment_size'       => 150,
                                'number_of_fragments' => 3,
                            ],
                            'chat_id' => StaticStd::instance(),
                        ],
                    ],
                ],
            ],
            actual: $result,
        );
    }

    public function test_from_検索条件を含めて_toArray_メソッドを呼んだ場合、意図したクエリの形が組み立てられること()
    {
        $searchQuery = new FluentQueryBuilder;

        $result = $searchQuery
            ->filter(function (Builder $filter) {
                $filter
                    ->term('chat_id', 'u968edd043c46262efe69ef21ad458c6d')
                    ->term('type', 1);
            })
            ->from(offset: 3)
            ->size(10)
            ->toArray();

        $this->assertSame(
            expected: [
                'body' => [
                    'query' => [
                        'bool' => [
                            'filter' => [
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
                            ],
                        ],
                    ],
                    'from'  => 3,
                    'size'  => 10,
                ],
            ],
            actual: $result,
        );
    }

    public function test_全パラメータ空っぽの場合にて_toArray_メソッドで意図したクエリの形が組み立てられること()
    {
        $searchQuery = new FluentQueryBuilder;

        $result = $searchQuery
            ->toArray();

        $this->assertSame(
            expected: [],
            actual: $result,
        );
    }
}
