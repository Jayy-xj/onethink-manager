<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/7
 * Time: 18:15
 */

namespace Wchat\Controller;


use Admin\Model\CategoryModel;
use Admin\Model\DocumentModel;
use Admin\Model\PictureModel;
use Think\Controller;

class NoticeController extends Controller
{

 public function notice($p=1){
     $model=new DocumentModel();
     $cate=new CategoryModel();
     $list_row=$cate->where(['id'=>40])->getField('list_row');
     $notice=$model->where(['category_id'=>40,'status'=>1])->page($p,$list_row)->select();
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
        $notices=$model->where(['category_id'=>40,'id'=>$id,'status'=>1])->select()['0'];
        $model2=M('DocumentArticle');
        $notices['content']=$model2->where(['id'=>$id])->getField('content');
//                var_dump($notices);exit;
        $this->assign($notices);
        $this->display();
    }

}