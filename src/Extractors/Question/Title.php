<?php

namespace pithyone\zhihu\crawler\Extractors\Question;

use pithyone\zhihu\crawler\Extractors\Extractor;

class Title implements Extractor
{
    static public function extract($crawler)
    {
        return $crawler->filter('.QuestionHeader-title')->text();
    }
}
