# Easy UC

为方便独立项目与 CMS 用户中心对接而打造的 Laravel 扩展包，极大地降低重复工作量！



## 功能

- OAuth 接口
- 供用户中心调用的用户管理接口



## 要求

- PHP >= 7.0
- Laravel >= 5.5



## 使用说明

### 安装

引入 Composer 包

```shell
composer require abelhalo/easyuc
```

发布配置文件（如需修改默认配置）

```php
php artisan vendor:publish --provider="Abel\EasyUC\ServiceProvider"
```

### 编写业务逻辑

首先在 `AppServiceProvider` 的 `register` 方法添加一行，如：

```php
public function register()
{
    $this->app->bind(\Abel\EasyUC\User::class, FooBar::class);
}
```

`FooBar` 类是编写业务逻辑的地方，可自行找地方存取，它需要实现 `Abel\EasyUC\User` 契约，以完成跟CMS 用户中心的对接。