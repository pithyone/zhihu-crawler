# zhihu-crawler

[![StyleCI](https://styleci.io/repos/98495729/shield?branch=master&style=flat)](https://styleci.io/repos/98495729)
[![Build Status](https://travis-ci.org/pithyone/zhihu-crawler.svg?branch=master)](https://travis-ci.org/pithyone/zhihu-crawler)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/pithyone/zhihu-crawler/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/pithyone/zhihu-crawler/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/pithyone/zhihu-crawler/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/pithyone/zhihu-crawler/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/pithyone/zhihu-crawler/v/stable)](https://packagist.org/packages/pithyone/zhihu-crawler)
[![Latest Unstable Version](https://poser.pugx.org/pithyone/zhihu-crawler/v/unstable)](https://packagist.org/packages/pithyone/zhihu-crawler)
[![License](https://poser.pugx.org/pithyone/zhihu-crawler/license)](https://packagist.org/packages/pithyone/zhihu-crawler)

🕷 轻量级知乎爬虫，基于 **[Goutte](https://github.com/FriendsOfPHP/Goutte)**

## Feature

- 简单易操作，不用关心 `Cookie`
- 自定义输出对象属性

## Requirement

- PHP >= 5.5

## Installation

```shell
$ composer require pithyone/zhihu-crawler
```

## Usage

### Question

```php
<?php

use pithyone\zhihu\crawler\Handler\QuestionHandler;

$questionHandler = new QuestionHandler(58481349);

$questionHandler->pick();
```

### Answer
```php
<?php

use pithyone\zhihu\crawler\Handler\AnswerHandler;

$answerHandler = new AnswerHandler(58481349, 1);

$answerHandler->pick(function ($item) {
    // 存储操作，保存到数据库...
    return $item['images']; // 输出回答中所有图片
});
```

### Collection

```php
<?php

use pithyone\zhihu\crawler\Handler\CollectionHandler;

$collectionHandler = new CollectionHandler(38324051, 1);

$collectionHandler->pick();
```

### MonthlyHot

```php
<?php

use pithyone\zhihu\crawler\Handler\MonthlyHotHandler;

$monthlyHotHandler = new MonthlyHotHandler();

$list = $monthlyHotHandler->pick();
```

## Links

- [知乎热门钓鱼贴图片版](http://zhihu.pithyone.tk/)
- [知乎热门收藏RSS](http://pithyone.tk/feed/zhihu/collection)
- [知乎本月最热RSS](http://pithyone.tk/feed/zhihu/month)

## License

MIT
