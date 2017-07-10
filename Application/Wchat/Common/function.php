<?php
/**
 * 检测验证码
 * @param  integer $id 验证码ID
 * @return boolean     检测结果
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function check_verify($code, $id = 1){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}


function ajaxData($code=0,$msg='',$data=[]){
    return [
        'status'=>$code,
        'data'=>$data,
        'msg'=>$msg,
    ];
}
function is_weixin(){
    if ( strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') !== false ) {
        return true;
    }
    return false;
}

function think_wchat_md5($str, $key = 'ThinkUCenter'){
    return '' === $str ? '' : md5(sha1($str) . $key);
}

/**
 * 获取用户积分
 */
function getScore(){
    $uid = session('user_auth')['uid'];
    $score = M('Member')->getFieldByUid($uid,'score');
    return $score;
}
