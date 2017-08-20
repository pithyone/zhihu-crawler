# zhihu-crawler

[![StyleCI](https://styleci.io/repos/98495729/shield?branch=master)](https://styleci.io/repos/98495729)
[![Latest Stable Version](https://poser.pugx.org/pithyone/zhihu-crawler/v/stable)](https://packagist.org/packages/pithyone/zhihu-crawler)
[![Total Downloads](https://poser.pugx.org/pithyone/zhihu-crawler/downloads)](https://packagist.org/packages/pithyone/zhihu-crawler)
[![Latest Unstable Version](https://poser.pugx.org/pithyone/zhihu-crawler/v/unstable)](https://packagist.org/packages/pithyone/zhihu-crawler)
[![License](https://poser.pugx.org/pithyone/zhihu-crawler/license)](https://packagist.org/packages/pithyone/zhihu-crawler)

🕷 轻量级知乎爬虫

## Feature

- 简单易操作，不用关心 `Cookie`
- 自定义输出对象属性，:smirk: 输出回答中所有图片
- 记录爬虫日志

## Installation

```shell
$ composer require pithyone/zhihu-crawler
```

## Basic Usage

```php
<?php

use GuzzleHttp\Client;
use pithyone\zhihu\crawler\Handler\AnswerHandler;
use pithyone\zhihu\crawler\ZhLite;

$config = [
    'debug' => true,
    'log'   => [
        'file' => __DIR__.'/tmp/crawler.log', // 日志存储位置
    ],
];

$client = new Client([
    'base_uri' => 'https://www.zhihu.com',
    'timeout'  => 5.0,
]);

$zhLite = new ZhLite($config);
$zhLite->setHandler(new AnswerHandler($client, 58481349, 1));
$zhLite->pick(function ($item) {
    // 存储操作，保存到数据库...
    // return $item['images']; // 输出回答中所有图片
});
```

## Documentation

- [Usage Instructions](/docs/index.md)

## Links

- [知乎热门钓鱼贴图片版](http://zhihu.pithyone.tk/)
- [热门收藏 - 知乎](http://pithyone.tk/feed/zhihu/collection)
- [本月最热 - 知乎](http://pithyone.tk/feed/zhihu/month)

## FAQ

- 如果日志中出现 `Get data failed`，不一定代表抓取失败，还有可能是被抓取属性值为空。

## License

MIT
