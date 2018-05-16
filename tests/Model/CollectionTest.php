<?php

namespace pithyone\zhihu\crawler\tests\Model;

use PHPUnit\Framework\TestCase;
use pithyone\zhihu\crawler\Model\Collection;

class CollectionTest extends TestCase
{
    public function testFind()
    {
        $collection = Collection::find(21827129);

        $this->assertInternalType('array', $collection);

        $this->assertArrayHasKey('title', $collection);
        $this->assertArrayHasKey('answers', $collection);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testException()
    {
        Collection::find(0);
    }
}
