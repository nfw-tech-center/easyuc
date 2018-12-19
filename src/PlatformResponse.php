<?php

namespace SouthCN\EasyUC;

class PlatformResponse extends \Illuminate\Http\JsonResponse
{
    public function __construct($code, $message = '', $status = 200)
    {
        parent::__construct([
            'errcode'    => $code,
            'errmessage' => $message,
            'data'       => null,
        ], $status);
    }
}
