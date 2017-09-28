
# 安装

```
yum install -y epel-release
yum install -y composer
```

# 下载 github 项目到 php include_path

```
$ cd /usr/lib/php/pear/
$ git clone https://github.com/solariumphp/solarium.git
```

# 安装项目依赖包

```
$ cd /usr/lib/php/pear/solarium/
$ composer update
```

# autoload
 
```
<?php
require_once('solarium/vendor/autoload.php');
```
