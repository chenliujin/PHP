

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

# 目录结构

|-- src
|-- tests
|-- phpunit.xml

## phpunit.xml
```
<?xml version="1.0" encoding="UTF-8"?>
<phpunit backupGlobals="false"
         backupStaticAttributes="false"
         colors="true"
         convertErrorsToExceptions="true"
         convertNoticesToExceptions="true"
         convertWarningsToExceptions="true"
         processIsolation="false"
         stopOnFailure="false">
    <testsuites>
        <testsuite name="Account Tests">
          <directory suffix="test.php">./tests/account</directory>
        </testsuite>
    </testsuites>
</phpunit>
```
