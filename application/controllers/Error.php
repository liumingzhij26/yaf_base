<?php
use Yaf\Registry;

class errorController extends Yaf\Controller_Abstract {

    public function errorAction( \Exception $exception ) {
        if( Registry::get('config')->environment != 'pro' ) {
            echo '<pre>';
            print_r($exception);
        }
        Yaf\Dispatcher::getInstance()->autoRender(false);
        switch ($exception->getCode()) {
            case YAF\ERR\NOTFOUND\MODULE:
            case YAF\ERR\NOTFOUND\CONTROLLER:
            case YAF\ERR\NOTFOUND\ACTION:
            case YAF\ERR\NOTFOUND\VIEW:
            case 4041:
                header("Content-type: text/html; charset=utf-8");
                header("status: 404 Not Found");
                $this->display("4041");
                break;
            case 4042:
                header("Content-type: text/html; charset=utf-8");
                header("status: 404 Not Found");
                $this->display("4042");
                break;
            default :
                header("Content-type: text/html; charset=utf-8");
                header("status: 500 Internal Server Error");
                if( Registry::get('config')->environment == 'pro' ) {
                    $this->display("500");
                }else{
                    echo $exception->getMessage();
                }
                break;
        }

    }
}  
