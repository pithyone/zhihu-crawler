[![Build Status](https://travis-ci.org/pithyone/zhihu-crawler.svg?branch=master)](https://travis-ci.org/pithyone/zhihu-crawler)
[![Latest Stable Version](https://poser.pugx.org/pithyone/zhihu-crawler/v/stable)](https://packagist.org/packages/pithyone/zhihu-crawler)
[![Latest Unstable Version](https://poser.pugx.org/pithyone/zhihu-crawler/v/unstable)](https://packagist.org/packages/pithyone/zhihu-crawler)
[![License](https://poser.pugx.org/pithyone/zhihu-crawler/license)](https://packagist.org/packages/pithyone/zhihu-crawler)

# ZhihuCrawler

> 轻量级知乎爬虫

## Installation

```bash
composer require pithyone/zhihu-crawler
```

## Usage

```php
$app = new \ZhihuCrawler\App();
```

### 收藏夹

```php
$collection = $app->collection->extract($id);

$collection->getTitle();

$collection->getList(function (\ZhihuCrawler\Extractors\AnswerExtractor $extractor) {
    return [
        'question_title' => $extractor->getQuestionTitle(),
        'vote_count' => $extractor->getVoteCount(),
        'author' => $extractor->getAuthor(),
        'author_bio' => $extractor->getAuthorBio(),
        'author_link' => $extractor->getAuthorLink(),
        'summary' => $extractor->getSummary(),
        'link' => $extractor->getLink()
    ];
});
```

### 本月最热

```php
$monthlyHot = $app->monthlyHot->extract();

$monthlyHot->getList(function (\ZhihuCrawler\Extractors\AnswerExtractor $extractor) {
    return [
        'question_title' => $extractor->getQuestionTitle(),
        'vote_count' => $extractor->getVoteCount(),
        'author' => $extractor->getAuthor(),
        'author_bio' => $extractor->getAuthorBio(),
        'author_link' => $extractor->getAuthorLink(),
        'summary' => $extractor->getSummary(),
        'link' => $extractor->getLink()
    ];
});
```

### 问题

```php
$question = $app->question->extract($id);

$question->getTitle();

$question->getDetail();

$question->getAnswerCount();
```

### 回答

```php
$questionAnswer = $app->questionAnswer->extract($questionId);

$questionAnswer->getList(function (\ZhihuCrawler\Extractors\AnswerExtractor $extractor) {
    return [
        'author' => $extractor->getAuthor(),
        'author_bio' => $extractor->getAuthorBio(),
        'author_link' => $extractor->getAuthorLink(),
        'vote_count' => $extractor->getVoteCount(),
        'summary' => $extractor->getSummary(),
        'link' => $extractor->getLink(),
        'image_list' => $extractor->getImageList()
    ];
});
```

## License

[MIT](https://github.com/pithyone/zhihu-crawler/blob/master/LICENSE)
