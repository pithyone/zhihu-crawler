<?php

namespace ZhihuCrawler\Tests;

use ZhihuCrawler\App;
use ZhihuCrawler\Model\Answer;
use ZhihuCrawler\Model\Collection;
use ZhihuCrawler\Model\MonthlyHot;
use ZhihuCrawler\Model\Question;

class AppTest extends TestCase
{
    /**
     * @return void
     */
    public function testGet()
    {
        $app = new App();

        $this->assertInstanceOf(Answer::class, $app->answer);
        $this->assertInstanceOf(Collection::class, $app->collection);
        $this->assertInstanceOf(MonthlyHot::class, $app->monthlyHot);
        $this->assertInstanceOf(Question::class, $app->question);
    }
}
