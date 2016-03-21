## 移除已安装的 PHP
```
$ yum list installed | grep php 	
php.x86_64                           5.3.3-27.el6_5.1                  @updates
php-cli.x86_64                       5.3.3-27.el6_5.1                  @updates
php-common.x86_64                    5.3.3-27.el6_5.1                  @updates
php-devel.x86_64                     5.3.3-27.el6_5.1                  @updates
php-fpm.x86_64                       5.3.3-27.el6_5.1                  @updates
...

$ yum remove php*
```

## remi-release
```
$ yum install -y http://rpms.famillecollet.com/enterprise/remi-release-6.rpm
```

### 安装 php 5.5
```
$ yum --enablerepo=remi,remi-php55 install php php-fpm php-common php-devel php-gd php-mysqlnd php-mcrypt php-mbstring php-pdo php-redis php-gearman php-http php-memcache php-xcache
```




<h2>安装 PHP 5.5</h2>
<pre>
$ yum install -y php55w-fpm php55w-pecl-gearman  php55w-devel

# laravel 5.x
$ yum install -y php55w-mcrypt php55w-mbstring php55w-pdo php55w-pecl-redis php55w-mysql

</pre>


<h2>参考文献</h2>
<ul>
	<li>https://webtatic.com/packages/php55/</li>
	<li>http://www.ahlinux.com/centos/22672.html</li>
	<li>https://www.softwarecollections.org/en/scls/rhscl/php55/</li>
</ul>
