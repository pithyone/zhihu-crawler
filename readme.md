# zhihu-crawler

[![Latest Stable Version](https://poser.pugx.org/pithyone/zhihu-crawler/v/stable)](https://packagist.org/packages/pithyone/zhihu-crawler)
[![Build Status](https://travis-ci.org/pithyone/zhihu-crawler.svg?branch=master)](https://travis-ci.org/pithyone/zhihu-crawler)

轻量级知乎爬虫

## Installation

```shell
composer require pithyone/zhihu-crawler
```

## Usage

Answer Model:

```php
<?php

use pithyone\zhihu\crawler\Model\Answer;

Answer::get(272059466);
```

Collection Model:

```php
<?php

use pithyone\zhihu\crawler\Model\Collection;

Collection::find(21827129);
```

Explore Model:

```php
<?php

use pithyone\zhihu\crawler\Model\Explore;

Explore::get();
```

Question Model:

```php
<?php

use pithyone\zhihu\crawler\Model\Question;

Question::find(272059466);
```
