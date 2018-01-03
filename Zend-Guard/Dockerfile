FROM docker.io/nginx-php-fpm:5.6.31

MAINTAINER chenliujin <liujin.chen@qq.com>

COPY ./lib/ZendGuardLoader.so /usr/lib64/php/modules/ZendGuardLoader.so

RUN echo '[Zend Guard Loader]' >> /etc/php.ini && \
    echo 'zend_extension = /usr/lib64/php/modules/ZendGuardLoader.so' >> /etc/php.ini && \
    echo '' >> /etc/php.ini && \
    echo '; Enables loading encoded scripts. The default value is On' >> /etc/php.ini && \
    echo 'zend_loader.enable=1' >> /etc/php.ini && \
    echo '; Disable license checks (for performance reasons)' >> /etc/php.ini && \
    echo 'zend_loader.disable_licensing=0' >> /etc/php.ini && \
    echo '; The Obfuscation level supported by Zend Guard Loader. The levels are detailed in the official Zend Guard Documentation. 0 - no obfuscation is enabled' >> /etc/php.ini && \
    echo 'zend_loader.obfuscation_level_support=3' >> /etc/php.ini && \
    echo '; Path to where licensed Zend products should look for the product license. For more information on how to create a license file, see the Zend Guard User Guide' >> /etc/php.ini && \
    echo 'zend_loader.license_path=' >> /etc/php.ini
 
