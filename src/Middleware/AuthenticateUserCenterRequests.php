<?php

namespace Abel\EasyUC\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

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
        if (config('easyuc.debug')) {
            return $next($request);
        }

        if ($request->time < now()->addMinutes(-5)->timestamp) {
            return $this->errorResponse(30004, '时间不合法');
        }

        if ($request->token != $this->calculateToken($request->time)) {
            return $this->errorResponse(30005, 'token不合法');
        }

        return $next($request);
    }

    protected function calculateToken($time)
    {
        return md5(
            config('easyuc.app') . $time . config('easyuc.ticket')
        );
    }

    protected function errorResponse($code, $message)
    {
        return new JsonResponse([
            'errcode'    => $code,
            'errmessage' => $message,
            'data'       => null,
        ], 403);
    }
}
