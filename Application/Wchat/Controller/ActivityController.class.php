<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/8
 * Time: 14:08
 */

namespace Wchat\Controller;


use Admin\Model\CategoryModel;
use Think\Controller;
use Admin\Model\DocumentModel;
use Admin\Model\PictureModel;
class ActivityController extends WchatController
{
    public function notice($p=1){
        $model=new DocumentModel();
        $cate=new CategoryModel();
        $list_row=$cate->where(['id'=>43])->getField('list_row');
        $notice=$model->where(['category_id'=>43,'status'=>1])->page($p,$list_row)->select();
        $notices=[];
        foreach ($notice as $k){
            $pic=new PictureModel();
            $k['image']=$pic->where(['id'=>$k['cover_id']])->select()['0']['path'];
            $k['create_time']=date('Y-m-d H:i:s',$k['create_time']);
            $notices[]=$k;
        }
//     var_dump($notices);
        $this->assign('notices',$notices);
        if(IS_AJAX){
            if ($notices){
                $this->ajaxReturn($notices);
                exit;
            }else{
                $this->ajaxReturn(false);
            }

        }
        $this->display();
    }
    public function detail($id=0){
        $model=new DocumentModel();
        $model->addView($id);
        $notices=$model->where(['category_id'=>43,'id'=>$id,'status'=>1])->select()['0'];
        $model2=M('DocumentArticle');
        $notices['content']=$model2->where(['id'=>$id])->getField('content');
        $this->assign($notices);
        $this->display();
    }
    /**
     * 申请活动
     */
    public function apply($id){
        $this->login();

        $userinfo = session('user_auth');
        $apply = M('apply');

        $old = $apply->where(['uid'=>$userinfo['uid'],'type'=>43,'act_id'=>$id])->find();
        if(!empty($old)){
            $this->error('已经申请过了！');
        }

        $data = $userinfo;
        $data['act_id'] = $id;
        $data['type'] = 43;
        $data['status'] = 2;
        $data['add_time'] = NOW_TIME;
//        var_dump($data);exit;
        if($apply->create($data)){
            $insert_id = $apply->add();
//            var_dump($insert_id);exit;
            if($insert_id !== false){
                $this->success('申请成功！');
            }
        };
        $this->error('申请失败！');
    }
}