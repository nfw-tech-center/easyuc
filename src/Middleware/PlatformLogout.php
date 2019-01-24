<?php

namespace SouthCN\EasyUC\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use SouthCN\EasyUC\Exceptions\ConfigUndefinedException;

class PlatformLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     * @throws ConfigUndefinedException
     */
    public function handle($request, Closure $next)
    {
        $id         = optional(Auth::user())->uuid;
        $token      = Cache::get("uc:{$id}:token");
        $logoutPath = config('easyuc.route.logout');

        if (!$logoutPath) {
            throw new ConfigUndefinedException('请配置UC_LOGOUT_ROUTE');
        }

        if (Cache::get("uc:$token:logout", false)) {
            if ($logoutPath != $request->path()) {
                Cache::forget("uc:$token:logout");

                return redirect('logout');
            }
        }

        return $next($request);
    }
}
