<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/8
 * Time: 9:09
 */

namespace Wchat\Controller;


use Admin\Model\CategoryModel;
use Admin\Model\DocumentModel;
use Admin\Model\PictureModel;
use Think\Controller;

class ServiceController extends Controller
{
    public function service($p=1){
        $model=new DocumentModel();
        $cate=new CategoryModel();
        $list_row=$cate->where(['id'=>41])->getField('list_row');
        $service=$model->where(['category_id'=>41,'status'=>1])->page($p,$list_row)->select();
        $services=[];
        foreach ($service as $k){
            $pic=new PictureModel();
            $k['image']=$pic->where(['id'=>$k['cover_id']])->select()['0']['path'];
            $k['create_time']=date('Y-m-d H:i:s',$k['create_time']);
            $services[]=$k;
        }
        $this->assign('services',$services);
        if(IS_AJAX){
            if ($services){
                $this->ajaxReturn($services);
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
        $services=$model->where(['category_id'=>41,'id'=>$id,'status'=>1])->select()['0'];
        $model2=M('DocumentArticle');
        $services['content']=$model2->where(['id'=>$id])->getField('content');
        $this->assign($services);
        $this->display();
    }
}