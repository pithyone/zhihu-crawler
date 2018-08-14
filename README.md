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

Answer Model:

```php
$app->answer->getList($questionId);
```

Collection Model:

```php
$app->collection->get($id);
```

MonthlyHot Model:

```php
$app->monthlyHot->getList();
```

Question Model:

```php
$app->question->get($id);
```
