
## 添加菜单 
```
mysql > SELECT * FROM zy_cap_wp.wp_posts where post_type = 'nav_menu_item';
mysql > UPDATE zy_cap_wp.wp_posts SET post_status = 'publish' where post_type = 'nav_menu_item';
```
