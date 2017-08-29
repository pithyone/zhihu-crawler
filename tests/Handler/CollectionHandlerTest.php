<?php
/**
 * CollectionHandlerTest.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/28
 */

namespace pithyone\zhihu\crawler\tests\Handler;

use PHPUnit\Framework\TestCase;
use pithyone\zhihu\crawler\Handler\CollectionHandler;

/**
 * Class CollectionHandlerTest.
 */
class CollectionHandlerTest extends TestCase
{
    public function testPick()
    {
        $collectionHandler = new CollectionHandler(38324051, 1);

        $list = $collectionHandler->pick();

        $this->assertInternalType('array', $list);
        $this->assertCount(10, $list);

        $data = $list[0];
        $this->assertInternalType('array', $data);
        $this->assertNotNull($data['title']);
        $this->assertNotNull($data['link']);
        $this->assertCount(9, $data);

        $titles = $collectionHandler->pick(function ($item) {
            return $item['title'];
        });

        $this->assertInternalType('array', $titles);
        $this->assertCount(10, $list);

        $this->assertEquals($data['title'], $titles[0]);
    }
}
