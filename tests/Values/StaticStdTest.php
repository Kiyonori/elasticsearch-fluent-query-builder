<?php

namespace Tests\Values;

use Kiyonori\ElasticsearchFluentQueryBuilder\Values\StaticStd;
use PHPUnit\Framework\TestCase;
use stdClass;

class StaticStdTest extends TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf(stdClass::class, StaticStd::instance());
    }
}
