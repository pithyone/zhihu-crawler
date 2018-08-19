<?php

/** @var \ZhihuCrawler\App $app */
$app = require __DIR__ . '/app.php';

$monthlyHot = $app->monthlyHot->extract();

$list = $monthlyHot->getList(function (\ZhihuCrawler\Extractors\AnswerExtractor $extractor) {
    return [
        'question_title' => $extractor->getQuestionTitle(),
        'vote_count' => $extractor->getVoteCount(),
        'author' => $extractor->getAuthor(),
        'author_bio' => $extractor->getAuthorBio(),
        'author_link' => $extractor->getAuthorLink(),
        'summary' => $extractor->getSummary(),
        'link' => $extractor->getLink(),
        'created' => $extractor->getCreated()
    ];
});

file_put_contents(__DIR__ . '/storage/monthlyHot.json', \GuzzleHttp\json_encode($list));
