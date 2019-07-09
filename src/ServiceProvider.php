<?php

namespace SouthCN\EasyUC;

use SouthCN\EasyUC\Exceptions\ConfigUndefinedException;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config.php', 'easyuc'
        );
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');

        $this->publishes([
            __DIR__ . '/../config.php' => config_path('easyuc.php'),
        ]);

        $this->checkConfig();
    }

    protected function checkConfig(): void
    {
        if (!config('easyuc.site_app_id')) {
            throw new ConfigUndefinedException('请配置UC_SITE_APP_ID');
        }

        if (!config('easyuc.route.logout')) {
            throw new ConfigUndefinedException('请配置UC_LOGOUT_ROUTE');
        }

        if (!config('easyuc.oauth.ip')) {
            throw new ConfigUndefinedException('请配置UC_OAUTH_TRUSTED_IP');
        }
    }
}
