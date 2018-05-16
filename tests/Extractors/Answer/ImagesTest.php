<?php

namespace pithyone\zhihu\crawler\tests\Extractors\Answer;

use PHPUnit\Framework\TestCase;
use pithyone\zhihu\crawler\Extractors\Answer\Images;
use Symfony\Component\DomCrawler\Crawler;

class ImagesTest extends TestCase
{
    /**
     * @dataProvider emptyProvider
     */
    public function testEmpty($html)
    {
        $images = Images::extract(new Crawler($html));

        $this->assertEmpty($images);

        $this->assertInternalType('array', $images);
    }

    public function testExtract()
    {
        $html = '<div class="zm-editable-content"><img src="" data-actualsrc=""></div>';

        $images = Images::extract(new Crawler($html));

        $this->assertInternalType('array', $images);

        foreach ($images as $image) {
            $this->assertInternalType('string', $image);
        }
    }

    public function emptyProvider()
    {
        return [
            ['<div></div>'],
            ['<div class="zm-editable-content"></div>'],
            ['<div class="zm-editable-content"><img src=""></div>'],
        ];
    }
}
