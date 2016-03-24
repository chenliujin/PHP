## 截取用户昵称
```php
<?php
function getDisplayName()
{
  $displayname = $customer_nickname ? $customer_nickname : $customer_firstname;
  $len = mb_strlen($displayname, 'utf8');
  if ( $len > 20 ) {
    $displayname = mb_strcut($displayname, 0, 17) . '...';
  }
}
```
