<?php

namespace SouthCN\EasyUC\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use SouthCN\EasyUC\Exceptions\ConfigUndefinedException;
use SouthCN\EasyUC\Services\UC;

class PlatformLogout
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @return mixed
     * @throws ConfigUndefinedException
     */
    public function handle($request, Closure $next)
    {
        $logoutPath = config('easyuc.route.logout');

        if (!$logoutPath) {
            throw new ConfigUndefinedException('请配置UC_LOGOUT_ROUTE');
        }

        if (Auth::guest()) {
            // 未登入时，无需检查统一登出信号
            return $next($request);
        }

        if (UC::signal()->checkLogout()) {
            if ($logoutPath != $request->path()) {
                $request->session()->invalidate();

                return redirect(env('UC_LOGIN_URL'));
            }
        }

        return $next($request);
    }
}
