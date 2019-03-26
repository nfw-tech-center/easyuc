<?php

namespace SouthCN\EasyUC\Middleware;

use Closure;
use SouthCN\EasyUC\Exceptions\ConfigUndefinedException;
use SouthCN\EasyUC\Services\UC;

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
        $logoutPath = config('easyuc.route.logout');

        if (!$logoutPath) {
            throw new ConfigUndefinedException('请配置UC_LOGOUT_ROUTE');
        }

        if (UC::signal()->checkLogout()) {
            if ($logoutPath != $request->path()) {
                return redirect('logout');
            }
        }

        return $next($request);
    }
}
