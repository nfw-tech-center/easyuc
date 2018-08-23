<?php

namespace Abel\EasyUC\Middleware;

use Closure;

class AuthenticateUserCenterRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->time < now()->addMinutes(-5)->timestamp) {
            return [
                'errcode'    => 30004,
                'errmessage' => '时间不合法',
                'data'       => null,
            ];
        }

        if ($request->token != $this->calculateToken($request->time)) {
            return [
                'errcode'    => 30005,
                'errmessage' => 'token不合法',
                'data'       => null,
            ];
        }

        return $next($request);
    }

    protected function calculateToken($time)
    {
        return md5(
            config('easyuc.app') . $time . config('easyuc.ticket')
        );
    }
}
