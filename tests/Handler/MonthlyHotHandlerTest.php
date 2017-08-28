<?php
/**
 * MonthlyHotHandlerTest.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/28
 */

namespace pithyone\zhihu\crawler\tests\Handler;

use PHPUnit\Framework\TestCase;
use pithyone\zhihu\crawler\Handler\MonthlyHotHandler;

/**
 * Class MonthlyHotHandlerTest.
 */
class MonthlyHotHandlerTest extends TestCase
{
    public function testPick()
    {
        $monthlyHotHandler = new MonthlyHotHandler();

        $list = $monthlyHotHandler->pick();

        $this->assertInternalType('array', $list);
        $this->assertCount(5, $list);

        $data = $list[0];
        $this->assertInternalType('array', $data);
        $this->assertNotNull($data['title']);
        $this->assertNotNull($data['link']);
        $this->assertCount(9, $data);

        $titles = $monthlyHotHandler->pick(function ($item) {
            return $item['title'];
        });

        $this->assertInternalType('array', $titles);
        $this->assertCount(5, $list);

        $this->assertEquals($data['title'], $titles[0]);
    }
}
