# Easy UC

Easy UC 是为方便平台 APP 与平台用户中心对接而打造的 Laravel 扩展包，可极大地降低重复工作量：

1. 无需理会跟平台用户中心交互的技术细节（HTTP、授权逻辑等）
2. 无需反复搭建繁琐的路由、控制器等结构
3. 只需专注子系统内部的业务逻辑



## 主要功能

- 平台定制版 OAuth 授权
- 统一登入
- 统一登出



## 环境要求

- PHP >= 7.1
- Laravel >= 5.6



## 认证流程

### 登入

1. APP 判断当前未登入，跳去平台用户中心登入页面（示例：`http(s)://platform.domain/usercenter/login?appid=应用注册的值`）
2. 平台用户中心登入成功后，会回调跳转到 APP 提供的回调地址（默认 `http(s)://platform-app.domain/uc/obtain-token`）
3. Easy UC 注册的 `uc/obtain-token` 路由接手登入回调过程，自动调用 Laravel 的 `Auth:login` 方法实现 APP 内登入

### 登出

1. APP 内部做登出处理，比如 `Auth:logout` ，完成 APP 层面登出
2. 向平台用户中心发送登出信号，以通知平台应用进行统一登出
3. 跳转去平台用户中心的登出地址，完成平台层面登出



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
UC_SITE_APP_ID=
UC_DEBUG=false
UC_PREFIX=
UC_LOGOUT_ROUTE=
UC_OAUTH_URL=
UC_OAUTH_LOGOUT=
UC_OAUTH_REDIRECT=/
```

如不了解 ENV 配置项的作用，可先发布配置文件，然后查看配置文件的注释。



### 服务提供者

首先在 `AppServiceProvider` 的 `register` 方法添加一行，如：

```php
public function register()
{
    $this->app->bind(
        \SouthCN\EasyUC\Contracts\UserCenterUser::class,
        \App\Repositories\UserCenterUser::class
    );
}
```

`App\Repositories\UserCenterUser` 类必须实现 `SouthCN\EasyUC\Contracts\UserCenterUser` 契约，可放在任意目录。



### 路由

要确认 Easy UC 的路由是否成功注册，可查看项目中已注册的路由：

```shell
php artisan route:list | grep uc
```



## 统一登入

### 业务逻辑

在`App\Repositories\UserCenterUser` 类编写 APP 内部的业务逻辑。

注：Easy UC 已内置了管理中心应用授权判断逻辑，无需重复实现。



### 自定义控制器逻辑

Easy UC 会自动注册一条 `uc/obtain-token` 路由，如要定制控制器逻辑，只需自行再注册一条 `uc/obtain-token` 路由：

```php
// routes/web.php
Route::get('uc/obtain-token', 'OAuthController@obtainToken');


// app/Http/Controllers/OAuthController.php
namespace App\Http\Controllers;

class OAuthController extends \SouthCN\EasyUC\Controllers\OAuthController
{
    public function obtainToken()
    {
        parent::obtainToken();

        // 此处演示自定义跳转逻辑
        return redirect("/#/?token=" . session('token'));
    }
}
```



## 统一登出

### 中间件

平台 APP 需要在适当位置添加 `\SouthCN\EasyUC\Middleware\PlatformLogout::class` 中间件，以监听平台统一登出信号。



### 控制器

以 Laravel 默认配置为例，默认的登出路径是 `POST /logout`，对应 `'Auth\LoginController@logout'`。为接入统一登出，需要修改 `'Auth\LoginController@logout'` 方法：

```php
// app/Http/Controllers/Auth/LoginController.php

public function logout(Request $request, \SouthCN\EasyUC\UserCenterApi $ucApi)
{
    // 通知平台用户中心进行统一登出操作
	  // 被动登出情景下，无需再向用户中心通知登出
	  // 此方法已自动处理此情景
    $ucApi->logout();

    // 原有登出逻辑……
}
```



## 版本升级

### 从 v2.x 升级

移除以下不再用到的 env 配置项：

```
UC_OAUTH_URL
UC_OAUTH_LOGOUT
```



部分类名、方法名的命名有变更，如有重写路由、继承、覆写方法等行为，记得同步命名变更：

1. `OAuthController` 已重命名为 `PlatformOAuthController`
2. `OAuthController@obtainToken` 已重命名为 `PlatformOAuthController@login`



如 APP 本身有用到旧版的 `abelhalo/api-proxy` 扩展包，请升级：

```
composer update abelhalo/api-proxy
```



### 从 v1.x 升级

更新 `composer.json` 信息：

```
composer remove abelhalo/easyuc
composer require southcn/easyuc
```



切换命名空间：

将所有 `Abel\EasyUC` 替换为`SouthCN\EasyUC`



移除无用 env 配置项，如有发布配置文件，对应到 easyuc.php 的配置项也一并移除：

```
UC_OAUTH_SWITCH_TO_DETAIL_INFO
```



增加 env 配置项，如有发布配置文件，请重新发布：

```
UC_SITE_APP_ID=用户中心site_app表的id字段值
```



简化的 `SouthCN\EasyUC\Contracts\UserCenterUser` 契约：

原来的 `update` 方法基本可变更为新的 `sync` 方法，其它方法全部可以移除



### 从 v1.0.0 升级

- `Abel\EasyUC\Contracts\UserCenterUser` 契约中的 `create` 方法不再使用，可移除