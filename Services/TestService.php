<?php
namespace Services;
use Services\BaseService as Base;
use Utils\Func;

class TestService extends Base
{

    /**
     * @return TestService
     */
    static public function Instance(){
        return parent::Instance();
    }

    public function getUrl() {
        return Func::SeftUrl();
    }

    public function getUrl1() {
        return Func::SeftUrl();
    }

}
