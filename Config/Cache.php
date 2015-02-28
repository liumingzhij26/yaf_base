<?php
namespace Config;

class Cache {

    public $prefix = JM_APP_NAME;

    public $redis = array(
        'cluster' => "mobile"
    );

    public $file = array(

    );

    public $ttl = array(
        'Mobile_EagleEye::getApps' => 60,
        'Crm_WeixinUser::getUserInfoByOpenids' => 5,
    );
}
