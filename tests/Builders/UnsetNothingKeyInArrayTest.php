<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Builders\UnsetNothingKeyInArray;
use Kiyonori\ElasticsearchFluentQueryBuilder\Values\Nothing;

test(
    'value 部分が Nothing：：class の場合は key ごと取り除かれていること',
    function () {
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

        expect($result)->toBe(
            [
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
        );
    }
);
