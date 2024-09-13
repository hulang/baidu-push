#### 百度推送 百度站长普通收录`api`多站点批量提交

- [x] 批量提交
- [x] 多站点提交(无需指定域名,由程序自动拆分)

#### 要求

1. php >= 7.4
2. Composer

#### 安装

```shell
composer require hulang/baidu-push
```
#### 用法

```php
use hulang\BaiduPush;

$token = '准入密钥';

$baidu = new BaiduPush($token);
```

#### 单条推送

```php
$baidu->push('http://www.php127.com/article/100000.html');
```

#### 多条推送

```php
$urls = [
    'http://www.test.com/article/100000.html',
    'http://www.php127.com/article/100001.html'
];

$baidu->pushs($urls);
```

#### 返回示例

```php
//多个站点会拆分多次推送,并反回相应站点的结果
Array
(
    [www.test.com] => Array
        (
            [error] => 401
            [message] => site error
        )

    [www.php127.com] => Array
        (
            [remain] => 99999
            [success] => 1
        )

)
```
