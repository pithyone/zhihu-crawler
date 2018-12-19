# ZhihuCrawler

ZhihuCrawler 是一个[知乎](https://www.zhihu.com/)轻量级爬虫，支持问题、收藏夹和本月最热。

[![Build Status](https://travis-ci.org/pithyone/zhihu-crawler.svg?branch=master)](https://travis-ci.org/pithyone/zhihu-crawler)
[![codecov](https://codecov.io/gh/pithyone/zhihu-crawler/branch/master/graph/badge.svg)](https://codecov.io/gh/pithyone/zhihu-crawler)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.5-8892BF.svg)](https://php.net/)
[![Latest Stable Version](https://poser.pugx.org/pithyone/zhihu-crawler/v/stable)](https://packagist.org/packages/pithyone/zhihu-crawler)
[![License](https://poser.pugx.org/pithyone/zhihu-crawler/license)](https://packagist.org/packages/pithyone/zhihu-crawler)

## Installation

```bash
composer require pithyone/zhihu-crawler
```

## Usage

### 问题

```php
<?php

require __DIR__ . '/../vendor/autoload.php';

$question = new \ZhihuCrawler\Question('290917836');

var_dump($question->getTitle());
var_dump($question->getDetail());
var_dump($question->getAnswerCount());

foreach ($question->getAnswerList() as $answer) {
    var_dump($answer->getTitle());
    var_dump($answer->getLink());
    var_dump($answer->getVoteCount());
    var_dump($answer->getAuthor());
    var_dump($answer->getAuthorLink());
    var_dump($answer->getAuthorBio());
    var_dump($answer->getSummary());
    var_dump($answer->getCreated());
}
```

### 收藏夹

```php
<?php

require __DIR__ . '/../vendor/autoload.php';

$collection = new \ZhihuCrawler\Collection('41893350');

var_dump($collection->getTitle());
var_dump($collection->getDetail());

foreach ($collection->getAnswerList() as $answer) {
    var_dump($answer->getTitle());
    var_dump($answer->getLink());
    var_dump($answer->getVoteCount());
    var_dump($answer->getAuthor());
    var_dump($answer->getAuthorLink());
    var_dump($answer->getAuthorBio());
    var_dump($answer->getSummary());
    var_dump($answer->getCreated());
}
```

### 本月最热

```php
<?php

require __DIR__ . '/../vendor/autoload.php';

$monthly = new \ZhihuCrawler\Monthly();

foreach ($monthly->getAnswerList() as $answer) {
    var_dump($answer->getTitle());
    var_dump($answer->getLink());
    var_dump($answer->getVoteCount());
    var_dump($answer->getAuthor());
    var_dump($answer->getAuthorLink());
    var_dump($answer->getAuthorBio());
    var_dump($answer->getSummary());
    var_dump($answer->getCreated());
}
```
