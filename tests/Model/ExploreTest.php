<?php

namespace pithyone\zhihu\crawler\tests\Model;

use PHPUnit\Framework\TestCase;
use pithyone\zhihu\crawler\Model\Explore;

class ExploreTest extends TestCase
{
    /**
     * @dataProvider getProvider
     */
    public function testGet($offset)
    {
        $explore = Explore::get($offset);

        $this->assertInternalType('array', $explore);

        $this->assertArrayHasKey('answers', $explore);
    }

    public function getProvider()
    {
        return [[0], [10000]];
    }
}
