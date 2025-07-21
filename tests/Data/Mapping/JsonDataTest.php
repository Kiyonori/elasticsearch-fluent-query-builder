<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\Data\Mapping\ChildNodes\BodyData;
use Kiyonori\ElasticsearchFluentQueryBuilder\Data\Mapping\ChildNodes\MappingsData;
use Kiyonori\ElasticsearchFluentQueryBuilder\Data\Mapping\JsonData;

test('JsonDataのコンストラクタに値を渡すことで、Data Transfer Objectが出来上がること',
    function () {
        $result = new JsonData(
            index: 'chat_histories',
            body: [
                'mappings' => [
                    'properties' => [
                        'pk' => [
                            'type' => 'long',
                        ],

                        'id' => [
                            'type' => 'long',
                        ],

                        'server_id' => [
                            'type'         => 'keyword',
                            'ignore_above' => 256,
                        ],

                        'type' => [
                            'type' => 'byte',
                        ],
                    ],
                ],
            ],
        );

        expect($result)
            ->toBeInstanceOf(JsonData::class)
            ->and($result->index)->toBe('chat_histories')
            ->and($result->body)->toBeInstanceOf(BodyData::class)
            ->and($result->body->mappings)->toBeInstanceOf(MappingsData::class)
            ->and($result->body->mappings->properties)->toBeInstanceOf(stdClass::class)
            ->and($result->body->mappings->properties->pk->type)->toBe('long')
            ->and($result->body->mappings->properties->id->type)->toBe('long')
            ->and($result->body->mappings->properties->server_id->type)->toBe('keyword')
            ->and($result->body->mappings->properties->server_id->ignore_above)->toBe(256)
            ->and($result->body->mappings->properties->type->type)->toBe('byte');
    }
);

test('JsonDataのtoArrayメソッドを呼ぶことで、隅々の要素までarrayにキャストされた内容が返ってくること',
    function () {
        $dataTransferObject = new JsonData(
            index: 'chat_histories',
            body: [
                'mappings' => [
                    'properties' => [
                        'pk' => [
                            'type' => 'long',
                        ],

                        'id' => [
                            'type' => 'long',
                        ],

                        'server_id' => [
                            'type'         => 'keyword',
                            'ignore_above' => 256,
                        ],

                        'type' => [
                            'type' => 'byte',
                        ],
                    ],
                ],
            ],
        );

        expect($dataTransferObject->toArray())->toBe(
            [
                'body' => [
                    'mappings' => [
                        'properties' => [
                            'pk'        => ['type' => 'long'],
                            'id'        => ['type' => 'long'],
                            'server_id' => [
                                'type'         => 'keyword',
                                'ignore_above' => 256,
                            ],
                            'type' => ['type' => 'byte'],
                        ],
                    ],
                ],
                'index' => 'chat_histories',
            ],
        );

        $this->assertSame(
            expected: [
                'body' => [
                    'mappings' => [
                        'properties' => [
                            'pk'        => ['type' => 'long'],
                            'id'        => ['type' => 'long'],
                            'server_id' => [
                                'type'         => 'keyword',
                                'ignore_above' => 256,
                            ],
                            'type' => ['type' => 'byte'],
                        ],
                    ],
                ],
                'index' => 'chat_histories',
            ],

            actual: $dataTransferObject->toArray(),
        );
    }
);
