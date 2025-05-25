<?php

namespace Tests\Values;

use PHPUnit\Framework\TestCase;
use Kiyonori\ElasticsearchFluentQueryBuilder\Values\Nothing;

class NothingTest extends TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf(Nothing::class, new Nothing());
    }
}
