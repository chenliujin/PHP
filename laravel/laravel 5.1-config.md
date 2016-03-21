## config/app.php
```php
<?
# AES-256-CBC 需要使用 32 位长度的 key，将 APP_KEY 改为 32 位
# 生成一个 32 位的 key：echo -n 'chenliujin' | md5sum
# 参考 https://laracasts.com/discuss/channels/forge/no-supported-encrypter-found-the-cipher-and-or-key-length-are-invalid-with-laravel-51?page=2

'key' => env('APP_KEY', '6cc8e925a57d8c6bb9738fa44f8ca006'),

'cipher' => 'AES-256-CBC',
```






<h2>权限</h2>
<pre>
$ chmod a+w bootstrap/cache
$ chmod -R 777 storage/
</pre>

<h2>开发模式</h2>
<h3>app/config/app.php</h3>
<pre>
	#'debug' => env('APP_DEBUG', false),
    'debug' => env('APP_DEBUG', true),
</pre>

<h2>Route</h2>
<p>laravel/app/Http/routes.php</p>

<h2>Nginx</h2>
<pre>
        location / {
                try_files $uri $uri/ /index.php$is_args$args;
        }
</pre>

<h2>Session</h2>
<p>/config/database.php</p>
<pre>
    'redis' => [

        'cluster' => false,

        'default' => [
            'host'     => env('SESSION_REDIS_HOST', '192.168.0.108'),
            'port'     => env('SESSION_REDIS_PORT', 6379),
            'database' => env('SESSION_REDIS_DB', 1),
            'password' => env('SESSION_REDIS_PASS', 123456),
        ],
    ],
</pre>

<h2>参考文献</h2>
<ul>
	<li>http://www.golaravel.com/laravel/docs/5.0/</li>
</ul>
