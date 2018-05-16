<?php

namespace pithyone\zhihu\crawler\tests\Extractors\Collection;

use PHPUnit\Framework\TestCase;
use pithyone\zhihu\crawler\Extractors\Collection\Summary;
use Symfony\Component\DomCrawler\Crawler;

class SummaryTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testException()
    {
        $html = '<div></div>';

        Summary::extract(new Crawler($html));
    }

    public function testExtract()
    {
        $html = '<div class="zh-summary">text</div>';

        $summary = Summary::extract(new Crawler($html));

        $this->assertEquals('text', $summary);
    }
}
