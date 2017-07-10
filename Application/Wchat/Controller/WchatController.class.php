<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/8
 * Time: 17:30
 */

namespace Wchat\Controller;


use Think\Controller;
use Think\Verify;

class WchatController extends Controller
{
    /* 空操作，用于输出404页面 */
    public function _empty(){
        $this->redirect('Index/index');
    }

    /* 验证码，用于登录和注册 */
    public function verify(){
        $verify = new \Think\Verify();
        $verify->entry(1);
    }
    protected function _initialize(){
        /* 读取站点配置 */
        $config = api('Config/lists');
        C($config); //添加配置

        if(!C('WEB_SITE_CLOSE')){
            $this->error('站点已经关闭，请稍后访问~');
        }
    }

    /* 用户登录检测 */
    protected function login(){
        /* 用户登录检测 */
        is_login() || $this->error('您还没有登录，请先登录！', U('User/login'));
    }
}