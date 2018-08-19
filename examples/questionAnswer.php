<?php

/** @var \ZhihuCrawler\App $app */
$app = require __DIR__ . '/app.php';

$questionAnswer = $app->questionAnswer->extract(27274812, 15);

$list = $questionAnswer->getList(function (\ZhihuCrawler\Extractors\AnswerExtractor $extractor) {
    return [
        'id' => $extractor->getId(),
        'question_id' => $extractor->getQuestionId(),
        'author' => $extractor->getAuthor(),
        'author_bio' => $extractor->getAuthorBio(),
        'author_link' => $extractor->getAuthorLink(),
        'vote_count' => $extractor->getVoteCount(),
        'summary' => $extractor->getSummary(),
        'link' => $extractor->getLink(),
        'image_list' => $extractor->getImageList()
    ];
});

file_put_contents(__DIR__ . '/storage/questionAnswer.json', \GuzzleHttp\json_encode($list));
