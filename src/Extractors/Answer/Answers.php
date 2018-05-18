<?php

namespace pithyone\zhihu\crawler\Extractors\Answer;

use pithyone\zhihu\crawler\Extractors\Extractor;

class Answers implements Extractor
{
    static public function extract($crawler)
    {
        return $crawler->filter('div[tabindex="-1"]')->each(function ($node) {
            return [
                'link'        => $node->filter('link')->attr('href'),
                'author'      => Author::extract($node),
                'author_link' => AuthorLink::extract($node),
                'bio'         => Bio::extract($node),
                'vote_count'  => $node->filter('.zm-item-vote-info')->attr('data-votecount'),
                'images'      => Images::extract($node),
            ];
        });
    }
}
