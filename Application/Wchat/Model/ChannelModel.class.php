<?php
/**
 * Created by PhpStorm.
 * User: yqcdw
 * Date: 2017/3/4
 * Time: 11:52
 */

namespace Wchat\Model;


use Think\Model;

class ChannelModel extends Model
{
    public function getChannelList(){
        $map['pid'] = 0;

        return $this->where($map)->order("`sort` asc")->select();
    }
}