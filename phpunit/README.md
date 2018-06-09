

- 安装 phpunit

```
curl http://phar.phpunit.cn/phpunit-5.7.phar > phpunit-5.7.phar
chmod +x phpunit-5.7.phar
mv phpunit-5.7.phar /usr/local/bin/phpunit
```

# 代码覆盖率

## PHP 扩展

```
yum install -y --enablerepo=remi,remi-php56 php-pecl-xdebug
```

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

    <filter>
        <whitelist>
            <directory suffix=".php">.</directory>
            <exclude>
                <directory suffix=".php">./config</directory>
                <directory suffix=".php">./data</directory>
                <directory suffix=".php">./tests</directory>
            </exclude>
        </whitelist>
    </filter>

    <logging>
        <log type="coverage-html" target="/data/www/phpunit/codeCoverage" charset="UTF-8"
            yui="true" highlight="true"
            lowUpperBound="50" highLowerBound="80"/>
        <log type="testdox-html" target="/data/www/phpunit/testdox.html" />
    </logging>

</phpunit>
```
