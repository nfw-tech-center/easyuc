# Easy UC

为方便独立项目与 CMS 用户中心对接而打造的 Laravel 扩展包，极大地降低重复工作量：

1. 无需理会跟 CMS 用户中心交互的 HTTP 细节
2. 无需搭建繁琐的路由、控制器结构
3. 只需专注业务逻辑



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

如果懒得折腾配置文件，可在 `.env` 文件里加上如下配置项：

```
UC_APP=
UC_TICKET=
UC_PREFIX=
UC_OAUTH_URL=
UC_OAUTH_REDIRECT=/
```

### 路由

查看 Easy UC 实际注册的路由

```shell
php artisan route:list | grep uc
```

### 编写业务逻辑

首先在 `AppServiceProvider` 的 `register` 方法添加一行，如：

```php
public function register()
{
    $this->app->bind(\Abel\EasyUC\User::class, \App\Repositories\UserCenterUser::class);
}
```

`UserCenterUser` 类是编写业务逻辑的地方，可自行找地方存放，它需要实现 `Abel\EasyUC\User` 契约，以完成跟 CMS 用户中心的对接。

示例代码：

```php
namespace App\Repositories;

use App\User;

class UserCenterUser implements \Abel\EasyUC\User
{
    /**
     * 获取 UID 列表
     *
     * @return Collection|array
     */
    public function all()
    {
        return User::pluck('uid');
    }

    /**
     * 为指定的 UID 创建业务系统用户
     *
     * @param $uid
     * @return void
     */
    public function create($uid)
    {
        User::create([
            'uid'    => $uid,
        ]);
    }

    /**
     * 根据 UID 删除业务系统用户
     *
     * @param $uid
     * @return void
     */
    public function destroy($uid)
    {
        User::whereUid($uid)->delete();
    }

    /**
     * 在 OAuth 过程中从用户中心同步用户数据到业务系统
     *
     * @param $user
     * @return Model 业务系统的 User 模型
     */
    public function sync($info)
    {
        $user = User::whereUid($info->id)->first();
        $data = [
            'uid'    => $info->id,
            'name'    => $info->name,
            'email'   => $info->email,
        ];

        $user
            ? $user->update($data)
            : $user = User::create($data);

        return $user;
    }
}
```
