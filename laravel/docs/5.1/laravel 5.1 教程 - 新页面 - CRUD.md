## route
* 增：Create
 * 前端：/blog/
 * 后端：/blog/
* 删：Delete
 * /blog/
* 改：Update
 * 前端：/blog/{id}
 * 后端：/blog/   
* 查：Read，列表页，有搜索功能
 * /blog/

## page
* 列表页
 * 搜索操作：时间
 * 编辑操作
 * 删除操作
 * 新建操作
 * 分页
* 新建页面
* 编辑页面

## config
```

```

## 按项目创建 Controller 和路由
### Stock
```
$ php artisan make:controller Stock/IndexController

$ vim app/Http/routes.php
Route::resource('stock/history', 'Stock\HistoryController');
```

### Blog
```
$ php artisan make:controller Blog/IndexController

$ vim app/Http/routes.php
Route::resource('blog/history', 'Blog\IndexController');
```



## 参考文献
* [使用laravel一分钟搭建CURD后台页面](http://www.cnblogs.com/yjf512/p/4061892.html)
* [RESTful 资源控制器](http://www.golaravel.com/laravel/docs/5.1/controllers/#restful-resource-controllers)
* [Laravel五大功能之Eloquent关系模式](http://blog.csdn.net/xd43100678/article/details/24376607)
* [Laravel 写的 blog](http://www.zhangxihai.cn/)
* [Laravel 5系列教程四：数据库和Eloquent](https://jellybool.com/post/programming-with-laravel-5-database-and-eloquent-model)
* [Laravel 5.1 教程1 - 10分钟写一个Blog](http://www.zhangxihai.cn/archives/120)
* [Laravel 5框架学习之Eloquent （laravel 的ORM）](http://www.jb51.net/article/63683.htm)
