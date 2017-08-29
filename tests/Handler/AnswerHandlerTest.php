<?php
/**
 * AnswerHandlerTest.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/28
 */

namespace pithyone\zhihu\crawler\tests\Handler;

use PHPUnit\Framework\TestCase;
use pithyone\zhihu\crawler\Handler\AnswerHandler;

/**
 * Class AnswerHandlerTest.
 */
class AnswerHandlerTest extends TestCase
{
    public function testPick()
    {
        $answerHandler = new AnswerHandler(58481349, 1);

        $list = $answerHandler->pick();

        $this->assertInternalType('array', $list);
        $this->assertCount(10, $list);

        $key = 0;
        foreach ($list as $k => $data) {
            if ($data['images']) {
                $key = $k;

                $this->assertInternalType('array', $data['images']);

                $image = $data['images'][0];
                $this->assertInternalType('string', $image);
                $this->assertStringStartsWith('http', $image);

                break;
            }
        }

        $images = $answerHandler->pick(function ($item) {
            return $item['images'];
        });

        $this->assertInternalType('array', $images);
        $this->assertCount(10, $images);

        $this->assertEquals($images[$key], $list[$key]['images']);
    }
}
