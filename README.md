# Easy UC

Easy UC 是为方便平台 APP 与平台用户中心对接而打造的 Laravel 扩展包，可极大地降低重复工作量：

1. 无需理会跟平台用户中心交互的技术细节（HTTP、授权逻辑等）
2. 无需反复搭建繁琐的路由、控制器等结构
3. 只需专注子系统内部的业务逻辑



## 主要功能

- OAuth 授权
- 用户管理接口（供平台用户中心调用）



## 环境要求

- PHP >= 7.0
- Laravel >= 5.5



## 认证流程

### 登入

1. APP 判断当前未登入，跳去平台用户中心登入页面
2. 平台用户中心登入成功后，会回调跳转到 APP 提供的回调地址（默认 `http(s)://platform-app.domain/uc/obtain-token`）
3. Easy UC 注册的 `uc/obtain-token` 路由接手登入回调过程，自动调用 Laravel 的 `Auth:login` 方法实现 APP 内登入

### 登出

1. APP 内部做登出处理，比如 `Auth:logout` ，完成 APP 级登出
2. 跳转去平台用户中心的登出地址，完成平台级登出



## 使用说明

### 安装

在 Laravel 项目中引入 Composer 包：

```shell
composer require abelhalo/easyuc
```

### 配置

如需修改默认配置，可发布配置文件：

```php
php artisan vendor:publish --provider="Abel\EasyUC\ServiceProvider"
```

在项目 `.env` 文件里加上如下配置项：

```
UC_APP=
UC_TICKET=
UC_DEBUG=false
UC_PREFIX=
UC_OAUTH_SWITCH_TO_DETAIL_INFO=false
UC_OAUTH_URL=
UC_OAUTH_REDIRECT=/
```

如不了解 ENV 配置项的作用，可先发布配置文件，然后查看配置文件的注释。

### 服务提供者

首先在 `AppServiceProvider` 的 `register` 方法添加一行，如：

```php
public function register()
{
    $this->app->bind(\Abel\EasyUC\Contracts\UserCenterUser::class, \App\Repositories\UserCenterUser::class);
}
```

`App\Repositories\UserCenterUser` 类必须实现 `Abel\EasyUC\Contracts\UserCenterUser` 契约，可放在任意目录。

### 路由

要确认 Easy UC 的路由是否成功注册，可查看项目中已注册的路由：

```shell
php artisan route:list | grep uc
```

### 业务逻辑

在`App\Repositories\UserCenterUser` 类编写 APP 内部的业务逻辑。

注：Easy UC 已内置了管理中心应用授权判断逻辑，无需重复实现。



## 版本升级

从 v1.0.0 升级：

- `Abel\EasyUC\Contracts\UserCenterUser` 契约中的 `create` 方法不再使用，可移除