<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/6
 * Time: 14:19
 */

namespace Admin\Model;

use Think\Model;

class SaleModel extends Model
{
    protected $_validate = array(
        array('title', 'require', '标题不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('tel', 'require', '电话不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('name', 'require', '姓名不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('price', 'require', '价格不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('tel', '/^1[3|4|5|8][0-9]\d{4,8}$/', '电话格式不正确', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
    );

    protected $_auto = array(
        array('add_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_UPDATE),
        array('status', '1', self::MODEL_INSERT),
    );
}