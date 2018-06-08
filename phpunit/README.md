

- 安装 phpunit

```
curl http://phar.phpunit.cn/phpunit-5.7.phar > phpunit-5.7.phar
chmod +x phpunit-5.7.phar
mv phpunit-5.7.phar /usr/local/bin/phpunit
```

# 代码覆盖率

```
phpunit --coverage-html reports/ tests/
```

