<?php
use Yaf\Dispatcher;
use Services\TestService as Test;
use Yaf\Controller_Abstract as Controller;

class indexController extends Controller {

    /**
     * 初始化控制器
     */
    public function init() {
        //禁止自动加载模板，需要手工指定模板路径
        Dispatcher::getInstance()->autoRender(false);
    }

    public function indexAction() {
        $this->getView()->assign("content", "Hello World");
        $this->display('index');
    }


    public function testAction() {
        $test = Test::Instance();
    }

}
