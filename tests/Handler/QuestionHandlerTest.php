<?php
/**
 * QuestionHandlerTest.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/28
 */

namespace pithyone\zhihu\crawler\tests\Handler;

use PHPUnit\Framework\TestCase;
use pithyone\zhihu\crawler\Handler\QuestionHandler;

/**
 * Class QuestionHandlerTest.
 */
class QuestionHandlerTest extends TestCase
{
    public function testPick()
    {
        $questionHandler = new QuestionHandler(58481349);

        $data = $questionHandler->pick();

        $this->assertInternalType('array', $data);
        $this->assertNotNull($data['title']);
        $this->assertCount(6, $data);

        $title = $questionHandler->pick(function ($item) {
            return $item['title'];
        });

        $this->assertEquals($data['title'], $title);
    }
}
