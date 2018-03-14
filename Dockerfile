FROM nginx:1.12.2 

MAINTAINER liujin.chen <liujin.chen@qq.com>

# 1. version:5.6.32
RUN yum install -y http://rpms.famillecollet.com/enterprise/remi-release-7.rpm && \
		yum install -y --enablerepo=remi,remi-php56 \
		php \
		php-fpm \
		php-pdo \
		php-mysqlnd \
		php-mcrypt \
		php-mbstring \
		php-redis \
		php-gearman \
		php-pecl-apcu\
		php-pecl-solr2 \
		php-gd && \
		yum erase -y remi-release && \
		yum clean all

# 2. timezone & include_path
RUN sed -i "s/;date\.timezone =/date\.timezone = Asia\/Shanghai/" /etc/php.ini && \
    sed -i "s/;include_path = \"\.:\/php\/includes\"/include_path = \"\.:\/php\/includes:\/usr\/lib\/php\/pear:\/data\/conf\"/" /etc/php.ini

RUN systemctl enable php-fpm

VOLUME ["/var/log/php-fpm"]
