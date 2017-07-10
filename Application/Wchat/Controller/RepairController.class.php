<?php
/**
 * Created by PhpStorm.
 * User: yqcdw
 * Date: 2017/3/5
 * Time: 21:54
 */

namespace Wchat\Controller;


class RepairController extends LoginController
{
    private static $status = [
        0=>"未处理",
        1=>"处理中",
        2=>"已处理",
    ];
    //报修列表
    public function index($p=1){
        $repair = D("Repair");

        //分页条件
        $map['uid'] = $this->uid;
        $map['status'] = ['gt',-1];
        //获取分页总条数
        $list = $repair->where($map)->page($p,C("PAGE_SIZE"))->order('add_time desc')->select();

        if(!empty($list)){
            foreach ($list as &$value){
                $value['status_txt'] = self::$status[$value['status']];
            }
        }
        if(IS_AJAX){
            if(empty($list)){
                $this->ajaxReturn(ajaxData(0,'没有数据'));
            }else{
                $this->ajaxReturn(ajaxData(1,'获取成功',$list));
            }
        }else{
            $this->assign('repair_list',$list);
            $this->display('list');
        }
    }

    public function detail($id=0){

        if(!is_numeric($id)){
            $this->error("参数错误！");
        }
        $repair = D('Repair');
        if(IS_POST){
            if(empty(I('post.comment'))){
                $this->error('请填写评论内容');
            }
            $rules = array (
                array('comment_time','time',2,'function'), // 对update_time字段在更新的时候写入当前时间戳
            );
            if($repair->auto($rules)->create(I('post'),2)!== false){
                $where['uid'] = $this->uid;
                $where['id'] = $id;
                $repair->where($where)->save();
                $this->success('评论成功',__SELF__);
                exit;
            }else{
                $this->error($repair->getError());
            }
        }

        $repair_info = $repair->where(['id'=>$id])->find();
        $repair_info['status_txt'] = self::$status[$repair_info['status']];
        $this->assign($repair_info);
        $this->display();
    }

    /**
     * 在线报修
     * @param string $verify
     */
    public function repair($verify=''){
        if(IS_POST){
            /* 检测验证码 */
            if(!check_verify($verify)){
                $this->error('验证码输入错误！');
            }

            $repair = D('Repair');
            if($repair->create(I('post'))!==false){
                $insert_result = $repair->add();
                if($insert_result>0){
                    $this->success('报修成功！',U("Index/index"));
                    exit;
                }
            }
            $this->error('报修失败'.$repair->getError());
        }else{
            $this->display();
        }
    }
}