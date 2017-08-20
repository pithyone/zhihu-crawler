### Question

```php
// ...

$zhLite->setHandler(new QuestionHandler($client, 58481349));
$zhLite->pick(function ($item) {
    // do something...
});
```

- **title** — 标题
- **description** — 描述

### Collection

```php
// ...

for ($i = 1; $i < 3; $i++) {
    $zhLite->setHandler(new CollectionHandler($client, 38324051, $i));
    $zhLite->pick(function ($item) {
        // do something...
    });
}
```

- **title** — 问题标题
- **link** — 回答链接
- **vote** — 回答赞同人数
- **author** — 作者昵称
- **author_link** — 作者知乎链接
- **bio** — 作者个人简介
- **summary** — 回答摘要
- **comment** — 回答评论数

### Answer

```php
// ...

for ($i = 1; $i < 3; $i++) {
    $zhLite->setHandler(new AnswerHandler($client, 58481349, $i));
    $zhLite->pick(function ($item) {
        // do something...
    });
}
```

- **avatar** — 作者头像
- **author** — 作者昵称
- **author_link** — 作者知乎链接
- **bio** — 作者个人简介
- **vote** — 回答赞同人数
- **link** — 回答链接
- **comment** — 回答评论数
- **summary** — 回答摘要
- **images** — 回答中所有图片链接
