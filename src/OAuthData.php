<?php

namespace SouthCN\EasyUC;

/**
 * @property-read int    id
 * @property-read int    org_id
 * @property-read string name
 * @property-read string email
 * @property-read bool   super
 * @property-read int    group
 * @property-read array  site_list
 */
class OAuthData
{
    protected $data;

    public function __construct($data)
    {
        $this->data  = $data;
        $this->super = (0 == $this->group);
    }

    public function __get($name)
    {
        if ('site_list' == $name) {
            return $this->data->site_list;
        }

        return $this->data->user->$name;
    }

    public function getInnerData()
    {
        return $this->data;
    }
}
