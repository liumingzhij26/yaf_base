<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/11/27
 * Time: 下午2:26
 */
namespace Services;
use MobLib\Service as Ser;
use MobLib\Cache;

class Service extends Ser  {

    static function Call($method,$parameter = array()) {
        $ret = parent::Call($method,$parameter);
        if(!empty($ret['result'])) {
            return $ret['result'];
        }
        if(!empty($ret)) {
            if($ret['code'] == '0') {
                return null;
            }
            return $ret;
        }
        return null;
    }

    static public function Smart($method,$parameter = array(),$reload = false) {
        $ret = parent::Smart($method,$parameter, $reload);
        if(!empty($ret['result'])) {
            return $ret['result'];
        }
        if(!empty($ret)) {
            if($ret['code'] == '0') {
                return null;
            }
            return $ret;
        }
        return null;

    }


    static public function SelfCall($method,$parameter = array()) {
        list($class,$function) = explode("::",$method);
        $class = "Services\\".$class;
        $class = new $class;
        return call_user_func_array(array($class,$function),$parameter);
    }


    static public function SelfSmart($method,$parameter = array(),$reload = false){

        $cache = Cache::Instance();

        $paramText = (empty($parameter)?"":http_build_query($parameter));
        if(strlen($paramText) >100 ){
            $paramText = md5($paramText);
        }
        $key = "service:$method:".$paramText;

        if( $reload ) {
            $val = false;
        } else {
            $val = $cache->get($key);
        }
        if( $val === false ) {
            $val = self::SelfCall($method,$parameter);
            if( $val === false) {
                return false;
            }else{

                $config = $cache->getConfig();

                if( isset($config['ttl'][$method]) )
                    $minutes = $config['ttl'][$method];
                else
                    throw new \Exception('service cache minutes not found,method:'.$method);

                $ttl = $minutes*60;
                $cache->set($key,$val,$ttl);
            }
        }
        return $val;
    }

}