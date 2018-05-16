<?php

namespace pithyone\zhihu\crawler\tests\Extractors\Collection;

use PHPUnit\Framework\TestCase;
use pithyone\zhihu\crawler\Extractors\Collection\Title;
use Symfony\Component\DomCrawler\Crawler;

class TitleTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testException()
    {
        $html = '<div></div>';

        Title::extract(new Crawler($html));
    }

    public function testExtract()
    {
        $html = '<div id="zh-fav-head-title">text</div>';

        $title = Title::extract(new Crawler($html));

        $this->assertEquals('text', $title);
    }
}
