<?php
/**
 * Created by PhpStorm.
 * User: yqcdw
 * Date: 2017/3/6
 * Time: 16:42
 */

namespace Admin\Controller;


class RepairController extends AdminController
{
    /**
     * 后台添加报修
     */
    public function add(){
        if(IS_POST){
            $model = D('Repair');
            if($model->create(I('post'))){
                $result = $model->add();
                if($result !== false){
                    $this->success('添加成功！',U('Center/index'));
                    exit;
                }
            }
            $this->error('添加失败！'.$model->getError());
        }else{
            $this->display('edit');
        }
    }
    public function changeStatus($id=0,$status=0){
        if(empty($id)){
            $this->error('参数错误！');
        }
        parent::editRow('Repair',['status'=>$status,'deal_time'=>NOW_TIME]);
    }
    
    public function delete($id=0){
        if(empty($id)){
            $this->error('参数错误！');
        }
        parent::delete('Repair');
    }

    /**
     * 查看详情
     * @param $id
     */
    public function detail($id){
        $repair = M("Repair")->where(['id'=>$id,'status'=>['egt',0]])->find();
        $this->assign($repair);
        $this->display();
    }
}