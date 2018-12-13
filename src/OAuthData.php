<?php

namespace Abel\EasyUC;

/**
 * @property-read int    id
 * @property-read int    org_id
 * @property-read string name
 * @property-read string email
 * @property-read bool   super
 * @property-read int    group
 */
class OAuthData
{
    protected $data;
    protected $switchToDetailInfo;

    public function __construct($data, bool $switchToDetailInfo = false)
    {
        $this->data               = $data;
        $this->switchToDetailInfo = $switchToDetailInfo;

        $this->super = (0 == $this->group);
    }

    public function __get($name)
    {
        return $this->switchToDetailInfo
            ? $this->data->user->$name
            : $this->data->$name;
    }

    public function getInnerData()
    {
        return $this->data;
    }
}
