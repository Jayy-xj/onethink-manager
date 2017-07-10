<?php

namespace Wchat\Model;


use Think\Model;

class RepairModel extends Model
{
    protected $_validate = [
        ['name','1,30','您的姓名必填',1,'length',self::MODEL_INSERT],
        ['tel',"/^1\d{10}$/",'请填正确的手机号',1,'regex',self::MODEL_INSERT],
        ['address','1,30','您的地址必填',1,'length',self::MODEL_INSERT],
        ['title','1,30','您的标题必填',1,'length',self::MODEL_INSERT],
        ['content','require','您的内容必填',1,'',self::MODEL_INSERT],
    ];

    protected $_auto = [
        array('uid','getUid',self::MODEL_INSERT,'callback'),
        array('add_time','time',self::MODEL_INSERT,'function'),
        array('sn','generateSn',self::MODEL_INSERT,'callback'),
    ];

    public function getUid(){
        return session('user_auth')['uid'];
    }

    public function generateSn(){
        return uniqid("IT").date("YMDHis");
    }
}