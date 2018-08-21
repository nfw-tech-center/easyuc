<?php

namespace Abel\EasyUC;

/**
 * @property-read  int    id
 * @property-read  int    org_id
 * @property-read  string name
 * @property-read  string email
 */
class OAuthData
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function __get($name)
    {
        return $this->data->$name;
    }
}
