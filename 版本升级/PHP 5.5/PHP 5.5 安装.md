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
### CentOS 6
```
$ yum install http://rpms.famillecollet.com/enterprise/remi-release-6.rpm
```
### CentOS 7
```
$ yum remove epel-release
$ yum install http://dl.fedoraproject.org/pub/epel/7/x86_64/e/epel-release-7-5.noarch.rpm

$ yum remove remi-release
$ yum install http://rpms.famillecollet.com/enterprise/remi-release-7.rpm
```
### 启用 remi release
```
$ vim /etc/yum.repos.d/remi.repo
[remi]
enabled=1

[remi-php55]
enabled=1
```

### 安装 php 5.5
```
$ yum --enablerepo=remi,remi-php55 install php php-fpm php-common php-devel
$ yum --enablerepo=remi,remi-php55 install php-gd php-mysqlnd php-mcrypt php-mbstring php-pdo php-redis php-gearman php-http php-memcache php-xcache php-soap
```


## 参考文献
* https://www.digitalocean.com/community/questions/how-to-install-php-5-6-on-centos-7-0-x64
* http://www.ahlinux.com/centos/22672.html
* https://www.softwarecollections.org/en/scls/rhscl/php55/
