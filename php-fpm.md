```
pm.max_requests = 500 # 进程处理完多少请求后自动重启，主要目的就是为了控制请求处理过程中的内存溢出，使得内存占用在一个可接受的范围内
```

# 参考文献
- [php-fpm参数优化](https://blog.linuxeye.cn/380.html)
- [高流量站点NGINX与PHP-fpm配置优化](http://blog.xiayf.cn/2014/05/03/optimizing-nginx-and-php-fpm-for-high-traffic-sites/)
- http://www.linuxde.net/category/linux_operation_and_maintenance_management_technology/application_acceleration_and_optimization/page/3
- http://blog.niubilety.com/2015/01/27/341.html
- https://cnodejs.org/topic/5668fede4a8dd3713ba4365b
- http://www.cnblogs.com/zhengah/p/4334314.html
- https://cnodejs.org/topic/5709e30112def0933c43ab91
- http://www.jianshu.com/p/43d04d8baaf7
- [https的性能测试报告](http://blog.csdn.net/longmarch12/article/details/6448351)
