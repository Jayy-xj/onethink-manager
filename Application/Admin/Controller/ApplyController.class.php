<?php
/**
 * Created by PhpStorm.
 * User: yqcdw
 * Date: 2017/3/6
 * Time: 20:07
 */

namespace Admin\Controller;


class ApplyController extends AdminController
{
    public function changeStatus($id=0,$status=0){
        parent::editRow('Apply',['status'=>$status,'deal_time'=>NOW_TIME]);
    }

    public function delete($id=0){
        parent::delete('Apply');
    }

}