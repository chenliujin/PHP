# PHP
修改php上传文件尺寸、响应时间
1.修改php.ini
1、post_max_size 指通过表单POST给PHP的所能接收的最大值，包括表单里的所有值，默认为8M（改为150M)，看你自己需要进行改变。
2、首先确认file_uploads = on 是否允许通过HTTP上传文件的开关，默认为ON即是开。 
upload_tmp_dir 通过HTTP上传文件的缓存目录,检查是否可写;
查找upload_max_filesize 即允许上传文件大小的最大值。默认为2M（改为100M）。
3、如果要上传>8M的文件，那么只设置上述四项还不定一定可以。最好对下面的参数也进行设置：
max_execution_time 每个PHP页面运行的最大时间值(秒)，默认30秒（改为0，不限制）。
max_input_time  每个PHP页面接收数据所需的最大时间，默认60秒（改为0，不限制）。
memory_limit 每个PHP页面所吃掉的最大内存，默认8M（改为128M，不限制）。

# Nginx

```
server {
	client_max_body_size 30m;
}
```

## Proxy

```
proxy-body-size 30m;
proxy_connect_timeout 75s;
```

