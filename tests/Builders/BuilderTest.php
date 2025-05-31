<?php

namespace Tests\Builders;

use PHPUnit\Framework\TestCase;
use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\Builder;

class BuilderTest extends TestCase
{
    public function test_toArray_メソッドで意図したクエリの「部分的な」形が組み立てられること()
    {
        $builder = new Builder;

        $result = $builder
            ->term('chat_id', 'u668aaa043c05062efe612321ad458c0a')
            ->term('type', 1)
            ->match('content', 'おはよう')
            ->match('content', 'またね')
            ->range(
                fieldName: 'created_time',
                gte: 1777777777777,
                lte: 1888888888888,
            )
            ->range('id', 333, 555)
            ->toArray();

        $this->assertSame(
            [
                [
                    'term' => [
                        'chat_id' => 'u668aaa043c05062efe612321ad458c0a',
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
                        'content' => 'またね',
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
                [
                    'range' => [
                        'id' => [
                            'gte' => 333,
                            'lte' => 555,
                        ],
                    ],
                ],
            ],
            $result,
        );
    }
}
