<?php
namespace Wchat\Controller;
use Think\Controller;
/**
 * 微信首页控制器
 */
class IndexController extends Controller {
    public function index(){
        $this->meta_title = '管理首页';
        $this->display('index');
    }
}
