<?php

namespace Tests\Data\Mapping;

use Kiyonori\ElasticsearchFluentQueryBuilder\Data\Mapping\ChildNodes\BodyData;
use Kiyonori\ElasticsearchFluentQueryBuilder\Data\Mapping\ChildNodes\MappingsData;
use Kiyonori\ElasticsearchFluentQueryBuilder\Data\Mapping\JsonData;
use PHPUnit\Framework\TestCase;
use stdClass;

class JsonDataTest extends TestCase
{
    public function test_JsonDataのコンストラクタに値を渡すことで、Data_Transfer_Objectが出来上がること()
    {
        $result = new JsonData(
            index: 'chat_histories',
            body: [
                "mappings" => [
                    "properties" => [
                        "pk" => [
                            "type" => "long",
                        ],

                        "id" => [
                            "type" => "long",
                        ],

                        "server_id" => [
                            "type"         => "keyword",
                            "ignore_above" => 256,
                        ],

                        "type" => [
                            "type" => "byte",
                        ],
                    ],
                ],
            ],
        );

        $this->assertInstanceOf(
            expected: JsonData::class,
            actual: $result,
        );

        $this->assertSame(
            expected: 'chat_histories',
            actual: $result->index,
        );

        $this->assertInstanceOf(
            expected: BodyData::class,
            actual: $result->body,
        );

        $this->assertInstanceOf(
            expected: MappingsData::class,
            actual: $result
                ->body
                ->mappings,
        );

        $this->assertInstanceOf(
            expected: stdClass::class,
            actual: $result
                ->body
                ->mappings
                ->properties,
        );

        $this->assertSame(
            expected: 'long',
            actual: $result
                ->body
                ->mappings
                ->properties
                ->pk
                ->type,
        );

        $this->assertSame(
            expected: 'long',
            actual: $result
                ->body
                ->mappings
                ->properties
                ->id
                ->type,
        );

        $this->assertSame(
            expected: 'keyword',
            actual: $result
                ->body
                ->mappings
                ->properties
                ->server_id
                ->type,
        );

        $this->assertSame(
            expected: 256,
            actual: $result
                ->body
                ->mappings
                ->properties
                ->server_id
                ->ignore_above,
        );

        $this->assertSame(
            expected: 'byte',
            actual: $result
                ->body
                ->mappings
                ->properties
                ->type
                ->type,
        );
    }

    public function test_JsonDataのtoArrayメソッドを呼ぶことで、隅々の要素までarrayにキャストされた内容が返ってくること()
    {
        $dataTransferObject = new JsonData(
            index: 'chat_histories',
            body: [
                "mappings" => [
                    "properties" => [
                        "pk" => [
                            "type" => "long",
                        ],

                        "id" => [
                            "type" => "long",
                        ],

                        "server_id" => [
                            "type"         => "keyword",
                            "ignore_above" => 256,
                        ],

                        "type" => [
                            "type" => "byte",
                        ],
                    ],
                ],
            ],
        );

        $this->assertSame(
            expected: [
                'body'  => [
                    'mappings' => [
                        'properties' => [
                            'pk'        => ['type' => 'long'],
                            'id'        => ['type' => 'long'],
                            'server_id' => [
                                'type'         => 'keyword',
                                'ignore_above' => 256,
                            ],
                            'type'      => ['type' => 'byte'],
                        ],
                    ],
                ],
                'index' => 'chat_histories',
            ],

            actual: $dataTransferObject->toArray(),
        );
    }
}
