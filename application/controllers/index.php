<?php
use Yaf\Dispatcher;

class indexController extends Yaf\Controller_Abstract {

    /**
     * 初始化控制器
     */
    public function init() {
        //禁止自动加载模板，需要手工指定模板路径
        Dispatcher::getInstance()->autoRender(FALSE);
    }

    public function indexAction() {
        echo Utils\Func::GuidString(time());
        $this->getView()->assign("content", "Hello World");
        $this->display('index');
    }



}
