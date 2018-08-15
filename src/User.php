<?php

namespace AbelHalo\EasyUC;

interface User
{
    public function all();

    public function create($uid);

    public function destory($uid);
}
