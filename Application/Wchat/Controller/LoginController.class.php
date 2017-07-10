<?php
namespace Wchat\Controller;


/**
 * 公共模块，用于必须登录后访问的模块
 * @author yqcdw
 *
 */
class LoginController extends WchatController
{
    protected $uid = 0;
    public function _initialize(){
        parent::_initialize();
        parent::login();
        $this->uid = session('user_auth')['uid'];
    }
}

?>