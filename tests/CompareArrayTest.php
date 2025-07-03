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
}
