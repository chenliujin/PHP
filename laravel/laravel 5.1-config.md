<h2>Ȩ��</h2>
<pre>
$ chmod a+w bootstrap/cache	
$ chmod -R 777 storage/
</pre>

<h2>����ģʽ</h2>
<h3>app/config/app.php</h3>
<pre>
	#'debug' => env('APP_DEBUG', false), 
    'debug' => env('APP_DEBUG', true), 

    #'cipher' => 'AES-256-CBC',
    'cipher' => MCRYPT_RIJNDAEL_128,

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

<h2>�ο�����</h2>
<ul>
	<li>https://laracasts.com/discuss/channels/forge/no-supported-encrypter-found-the-cipher-and-or-key-length-are-invalid-with-laravel-51?page=2</li>
	<li>http://www.golaravel.com/laravel/docs/5.0/</li>
</ul>