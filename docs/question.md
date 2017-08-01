# 问题

> 可直接参考 [demo](../examples/question.php)

## 获取实例

```php
use pithyone\zhihu\crawler\Application;

// ...

$app = new Application($config);

$question = $app->question;
```

## 设置问题ID

```php
$question->id($id)
```

## 得到详情

```php
$question->get()
```

### 详情结构

```json
{
    "title": "身材好是一种怎样的体验？",
    "description": "镜像问题：身材差是一种怎样的体验? - 生活"
}
```

```text
title           标题
description     描述
```
