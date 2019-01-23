<?php

namespace SouthCN\EasyUC\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class PlatformLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     * @throws \SouthCN\EasyUC\Exceptions\ApiFailedException
     */
    public function handle($request, Closure $next)
    {
        $token      = session('uc:token');
        $logoutPath = config('easyuc.route.logout');

        if (Cache::get("uc:$token:logout", false)) {
            if ($logoutPath != $request->path()) {
                return redirect('logout');
            }
        }

        return $next($request);
    }
}
