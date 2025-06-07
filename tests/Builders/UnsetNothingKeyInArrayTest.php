<?php

namespace Tests\Builders;

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\UnsetNothingKeyInArray;
use Kiyonori\ElasticsearchFluentQueryBuilder\Values\Nothing;
use PHPUnit\Framework\TestCase;

class UnsetNothingKeyInArrayTest extends TestCase
{
    public function test_value_部分が_Nothing：：class_の場合は_key_ごと取り除かれていること()
    {
        $input = [
            'key1' => [
                'sub_key' => [
                    'sub_sub_key_1' => Nothing::make(),
                    'sub_sub_key_2' => 123,
                ],
            ],
            'key2' => Nothing::make(),
            'key3' => [
                'sub_key_a' => Nothing::make(),
            ],
            'key4' => [
                'sub_key_in_key4' => [
                    'sub_sub_key_123' => 'aaa',
                    'sub_sub_key_223' => false,
                ],
            ],
            'key5' => [
                'sub_key_b' => [
                    'sub_sub_key' => [
                        'sub_sub_sub_key' => [
                            'sub_sub_sub_sub_key' => Nothing::make(),
                        ],
                    ],
                ],
            ],
            'key6' => [
                'sub_key_b' => [
                    'sub_sub_key' => [
                        'sub_sub_sub_key' => [
                            'sub_sub_sub_sub_key_1' => true,
                            'sub_sub_sub_sub_key_2' => Nothing::make(),
                        ],
                    ],
                ],
            ],
        ];

        $result = (new UnsetNothingKeyInArray)->execute(
            $input,
        );

        $this->assertSame(
            expected: [
                'key1' => [
                    'sub_key' => [
                        // 'sub_sub_key_1' => Nothing::make(),
                        'sub_sub_key_2' => 123,
                    ],
                ],
                // 'key2' => Nothing::make(),
                // 'key3' => [
                //    'sub_key_a' => Nothing::make(),
                // ],
                'key4' => [
                    'sub_key_in_key4' => [
                        'sub_sub_key_123' => 'aaa',
                        'sub_sub_key_223' => false,
                    ],
                ],
                // 'key5' => [
                //    'sub_key_b' => [
                //        'sub_sub_key' => [
                //            'sub_sub_sub_key' => [
                //                'sub_sub_sub_sub_key' => Nothing::make(),
                //            ],
                //        ],
                //    ],
                // ],
                'key6' => [
                    'sub_key_b' => [
                        'sub_sub_key' => [
                            'sub_sub_sub_key' => [
                                'sub_sub_sub_sub_key_1' => true,
                                // 'sub_sub_sub_sub_key_2' => Nothing::make(),
                            ],
                        ],
                    ],
                ],
            ],
            actual: $result,
        );
    }
}