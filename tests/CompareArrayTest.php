<?php

use Kiyonori\ElasticsearchFluentQueryBuilder\CompareArray;
use PHPUnit\Framework\TestCase;

class CompareArrayTest extends TestCase
{
    function test_2つの配列を比較し、全く同じであることを意味する「空っぽの配列」が返ってくること()
    {
        $result = app(CompareArray::class)->execute(
            current: [
                'a' => 111,
                'b' => 222,
            ],
            new: [
                'a' => 111,
                'b' => 222,
            ],
        );

        $this->assertSame(
            expected: [],
            actual: $result,
        );
    }

    function test_2つの配列を比較し、差異のある部分が配列として返ってくること()
    {
        $result = app(CompareArray::class)->execute(
            current: [
                'a' => 111,
                'b' => 222,
            ],
            new: [
                'a' => 111,
                'b' => 223, // 👀 ここに注目❗️
            ],
        );

        $this->assertSame(
            expected: [
                'b' => 223,
            ],
            actual: $result,
        );
    }

    public function test_2つの配列を比較し、＄new_側の1階層目に欠けているキーがあっても無視され、差分として検知されないこと(
    )
    {
        $result = app(CompareArray::class)->execute(
            current: [
                'a' => 111,
                'b' => 222,
            ],
            new: [
                'a' => 111,
                // 'b' => 222, // 👀 ここに注目❗️
            ],
        );

        $this->assertSame(
            expected: [],
            actual: $result,
        );
    }

    public function test_2つの配列を比較し、＄new_側の1階層目に新しいキーがあっても無視され、差分として検知されないこと()
    {
        $result = app(CompareArray::class)->execute(
            current: [
                'a' => 111,
                'b' => 222,
            ],
            new: [
                'a' => 111,
                'b' => 222,
                'c' => 333, // 👀 ここに注目❗️
            ],
        );

        $this->assertSame(
            expected: [],
            actual: $result,
        );
    }

    public function test_ネストされた配列同士の比較_＄current_と_＄new_の内容がまったく同じである場合、全く同じであることを意味する「空っぽの配列」が返ってくること()
    {
        $result = app(CompareArray::class)->execute(
            current: [
                'a' => 111,
                'b' => [
                    'bb1' => 'あ',
                    'bb2' => 'か',
                ],
                'c' => 333,
            ],
            new: [
                'a' => 111,
                'b' => [
                    'bb1' => 'あ',
                    'bb2' => 'か',
                ],
                'c' => 333,
            ],
        );

        $this->assertSame(
            expected: [],
            actual: $result,
        );
    }

    public function test_ネストされた配列同士の比較_＄current_と_＄new_のうち細部の_key_の並び順が_＄current_側と異なる場合、差分として1階層目の親のキーを含む配列が返ってくること()
    {
        $result = app(CompareArray::class)->execute(
            current: [
                'a' => 111,
                'b' => [
                    'bb1' => 'あ',
                    'bb2' => 'か',
                ],
                'c' => 333,
            ],
            new: [
                'a' => 111,
                'b' => [
                    'bb2' => 'か', // 👀 ここに注目❗️
                    'bb1' => 'あ', // 👀 ここに注目❗️
                ],
                'c' => 333,
            ],
        );

        $this->assertSame(
            expected: [
                'b' => [
                    'bb2' => 'か',
                    'bb1' => 'あ',
                ],
            ],
            actual: $result,
        );
    }
}
