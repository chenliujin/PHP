## 版权
* 作者：<a href="http://www.chenliujin.com">陈柳锦</a>
* 主页：<a href="http://www.chenliujin.com">http://www.chenliujin.com</a>
* 邮箱：liujin.chen@qq.com

## 背景
使用 laravel 框架对 zencart 站点或其它框架实现的项目（如：ThinkPHP）进行重构，把业务一步一步转移到 laravel 的项目中，此时需要共享两边的 session。需要实现 laravel 生成的 session 数据 PHP 原生 session 可以读取，反之亦然，最终大大降低系统重构的复杂度。

## 方案
### laravel session 序列化方法
php serialize
### PHP session 使用的序列化算法
| 处理器         | 对应的存储格式    |
| ------------------ |:---------------------|
| php_binary      | 键名的长度对应的 ASCII 字符＋键名＋经过 serialize() 函数反序列处理的值 |
| php           | 键名＋竖线＋经过 serialize() 函数反序列处理的值   |
|php_serialize (php>=5.5.4) |经过 serialize() 函数反序列处理的数组|
### php 5.3.3
<img src="https://raw.githubusercontent.com/chenliujin/PHP/master/laravel/doc/img/php.session.5.3.3.PNG" />

### php 5.5.32
<img src="https://raw.githubusercontent.com/chenliujin/PHP/master/laravel/doc/img/php.session.5.5.32.PNG" />

## PHP
* 升级 PHP 到 5.5
* php.ini
```
[Session]
session.serialize_handler = php_serialize # 使用新的序列化方法
```

## laravel
### session.name ：config/session.php
```
    'cookie' => 'zenid', # 与 zencart 保持一致
```

### redis key prefix：config/cache.php
```php
<?
    'stores' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'prefix' => 'PHPREDIS_SESSION', # 与 zencart 保持一致
        ],
    ],
```

### laravel session 存储：Illuminate\Session\Store.php
```php
<?
    public function save()
    {
        $this->addBagDataToSession();

        $this->ageFlashData();

        $this->handler->write($this->getId(), $this->prepareForStorage(serialize($this->attributes)));

        $this->started = false;
    }
```

### laravel session 读取：Illuminate\Session\Store.php
```php
<?
    /**
     * Read the session data from the handler.
     *
     * @return array
     */
    protected function readFromHandler()
    {
        $data = $this->handler->read($this->getId());

        if ($data) {
            $data = @unserialize($this->prepareForUnserialize($data));

            if ($data !== false && $data !== null && is_array($data)) {
                return $data;
            }
        }

        return [];
    }
```


## 验证对方保存的 session 数据可以正常读取
### zencart 写，laravel 读
* zencart 写
 > PHPREDIS_SESSION:02103fd8mo5jb7qia51lnu7lh5
```
"a:1:{s:13:\"securityToken\";s:32:\"3c83dcba20e98cfd77ba70db6de93497\";}"
```

* laravel 读
> 读取失败

* debug
```php
<?
    protected function readFromHandler()
    {
        $data = $this->handler->read($this->getId());

        error_log(var_export($data, true)); # 跟踪从 redis 中取出的数据，确定问题原因

        if ($data) {
            $data = @unserialize($this->prepareForUnserialize($data));

            if ($data !== false && $data !== null && is_array($data)) {
                return $data;
            }
        }

        return [];
    }
```
* error_log
 ```
 [15-Mar-2016 07:59:01 UTC] array (
  'securityToken' => '03eac95413cbfcc16ea599f36d2e24e2',
)
```

* 问题原因
> $data = $this->handler->read($this->getId())，$data 是一个数组，印证了可以反序列化成功，但是是被 handler->read 多反序列化了一次（取出来应该是一个字符串，后面才进行反序列化），说明 handler->read 具有反序列化功能。因此 zencart 保存和读取时需要进行多一次序列化和反序列化。

### zencart 多进行一次序列化和反序列化
* 写
```php
<?
function _sess_write($key, $val) {
    global $SESS_LIFE;

    $val = serialize($val); #序列化多一次

    $redis_new = new Redis();
    $redis_new->pconnect(SESSION_REDIS_HOST_NEW, SESSION_REDIS_PORT_NEW);
    $redis_new->auth(SESSION_REDIS_PASSWORD_NEW);
    $redis_new->select(SESSION_REDIS_DB_NEW);

    $rd_ssk = 'PHPREDIS_SESSION:' . $key ;
    $redis_new->setex($rd_ssk,$SESS_LIFE, $val);
    return true;
}
```
* 读
```php
<?
function _sess_read($key) {
    $redis_new = new Redis();
    $redis_new->pconnect(SESSION_REDIS_HOST_NEW, SESSION_REDIS_PORT_NEW);
    $redis_new->auth(SESSION_REDIS_PASSWORD_NEW);
    $redis_new->select(SESSION_REDIS_DB_NEW);
    $rd_ssk = 'PHPREDIS_SESSION:' . $key ;
    $sess_value = $redis_new->get($rd_ssk);

    $sess_value = unserialize($sess_value); #反序列化

    return $sess_value;
}
```
* redis
```
"s:67:\"a:1:{s:13:\"securityToken\";s:32:\"8a190ebc150a39dd8a7bd46a9c2665cc\";}\";"
```
* laravel 读取成功

### laravel 写，zencart 读
* laravel 写
```php
<?
public function save()
{
    $this->addBagDataToSession();

    $this->ageFlashData();

    # 模拟 session 赋值  
    $this->attributes = array(
        'securityToken' => '03eac95413cbfcc16ea599f36d2e24e2',
    );

    $this->handler->write($this->getId(), $this->prepareForStorage(serialize($this->attributes)));

    $this->started = false;
}
```
* redis
 * key
 > PHPREDIS_SESSION:6d8d36a7abe4318891c60308f47bb8ed489bfb5a
 * value
```
"s:67:\"a:1:{s:13:\"securityToken\";s:32:\"03eac95413cbfcc16ea599f36d2e24e2\";}\";"
```
 * 此时 laravel 和 zencart 写入 redis 的数据保持了一致
* zencart 读


### session key 冲突
两边都在 session 中保存 language，此时需保持 key 和 value 定义一致，否则会将对方的数据覆盖掉，引起异常。
* zencart
```
$_SESSION['language'] = 'english';
```
* laravel
```
Session::put('language', 'en');
```


## 参考文献
<ul>
	<li><a href="http://www.freebuf.com/articles/web/90837.html">PHP序列化与反序列化解读</a></li>
	<li>http://ju.outofmemory.cn/entry/99681</li>
	<li>http://www.thinksaas.cn/manual/php/ref.session.html</li>
	<li>http://php.net/manual/zh/ref.session.php</li>
	<li>http://php.net/manual/zh/session.setup.php</li>
	<li>http://drops.wooyun.org/tips/3909</li>
	<li>https://segmentfault.com/q/1010000003776645?_ea=365137</li>
</ul>
