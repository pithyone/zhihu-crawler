<?php

namespace pithyone\zhihu\crawler\Extractors\Question;

use pithyone\zhihu\crawler\Extractors\Extractor;

class Detail implements Extractor
{
    static public function extract($crawler)
    {
        try {
            return $crawler->filter('.RichText')->text();
        } catch (\Exception $e) {
            return '';
        }
    }
}
