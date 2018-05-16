<?php

namespace pithyone\zhihu\crawler\Extractors\Answer;

use pithyone\zhihu\crawler\Extractors\Extractor;

class Images implements Extractor
{
    static public function extract($crawler)
    {
        $images = $crawler->filter('div[class^="zm-editable-content"]')->filter('img')->each(function ($node
        ) {
            return $node->attr('data-actualsrc');
        });

        return array_values(array_filter($images));
    }
}
