
# Download
- http://www.zend.com/en/products/zend-guard


# 试用版
- Encoded files will not be optimized, and will expire after 14 days.(加密的代码不会优化，并且加密的文件 14 天后过期)
- Generated licenses will expire after 3 days.(如果使用 license 授权，license 3 天后过期)


---


# license
- Product Expiration 
- IP Numbers
- Zend Host ID's 
- Concurrent Users 


## Licensing 
- Configure License Keys -> Generate
- Generate Product License File


## 配置
```
zend_loader.license_path=
```


### 多个 license 文件
```
zend_loader.license_path=/data/Zend/licenses/project1.zl:/data/Zend/licenses/project2.zl
```


---


# Encoding and Obfuscation methods(混淆设置)
- [ ] Remove PHPDoc Blocks
- [ ] Remove Line Numbers


# 参考文献
- [官网](http://www.zend.com/)
- [PHP使用Zend Guard 6.0加密方法讲解](http://www.piaoyi.org/php/PHP-Zend-Guard-encode.html)
- https://www.cnblogs.com/gamir/p/4181775.html
