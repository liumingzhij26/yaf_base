<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/11/24
 * Time: 下午3:22
 */
namespace Services;

class BaseService
{

    static protected $instance;

    static protected $cache;

    static public function Instance()
    {
        $class = get_called_class();
        if (empty(self::$instance[$class])) {
            self::$instance[$class] = new $class();
        }
        return self::$instance[$class];
    }

    protected function __construct() {}

    protected function __clone(){}

    public function __call($name, $arg) {}


}