<?php

/** @var \ZhihuCrawler\App $app */
$app = require __DIR__ . '/app.php';

$question = $app->question->extract(27274812);

var_dump($question->getId());

var_dump($question->getTitle());

var_dump($question->getDetail());

var_dump($question->getAnswerCount());
