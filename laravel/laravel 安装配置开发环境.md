## 安装 Composer
```
$ yum install composer
```

## 下载 laravel
```
$ git clone https://github.com/laravel/laravel.git
```
### composer 中国镜像
```
$ vim laravle/composer.json
{
    "config": {
        "preferred-install": "dist",
        "secure-http": false
    },
    "repositories": [
        {"type": "composer", "url": "http://pkg.phpcomposer.com/repo/packagist/"},
        {"packagist": false}
    ]
}
```

### 安装第三方依赖包
```
$ cd laravel
$ composer install
```

## 参考文献
* 
