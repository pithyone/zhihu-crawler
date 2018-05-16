<?php

namespace pithyone\zhihu\crawler\Extractors\Answer;

use pithyone\zhihu\crawler\Extractors\Extractor;

class Bio implements Extractor
{
    static public function extract($crawler)
    {
        try {
            return $crawler->filter('span[class="bio"]')->attr('title');
        } catch (\Exception $e) {
            return '';
        }
    }
}
