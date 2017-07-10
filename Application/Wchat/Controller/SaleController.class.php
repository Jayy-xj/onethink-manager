<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/7
 * Time: 16:03
 */

namespace Wchat\Controller;


use Admin\Model\PictureModel;
use Think\Controller;

class SaleController extends Controller
{
    public function index(){
    $model = D("Sale");
    $chuzu = $model->where(['type'=>0])->select();
    $sale = $model->where(['type'=>1])->select();
    $sales=[];
    $chuzus=[];
    foreach ($sale as $k){
        $pic=new PictureModel();
        $k['image']=$pic->where(['id'=>$k['img']])->select()['0']['path'];
        $sales[]=$k;
    }
    foreach ($chuzu as $k){
        $pic=new PictureModel();
        $k['image']=$pic->where(['id'=>$k['img']])->select()['0']['path'];
        $chuzus[]=$k;
    }
    $this->assign('chuzus',$chuzus);
    $this->assign('sales',$sales);
    $this->display();
    }
    public function detail($id=0){
        $detail = $model = D("Sale")->where(['id'=>$id])->find();
        $pic=new PictureModel();
        $detail['image']=$pic->where(['id'=>$detail['img']])->select()['0']['path'];
        if ($detail['unit']){
            $detail['un']='/万元';
        }else{
            $detail['un']='元/月';
        }
//        var_dump($detail);exit;
        $this->assign($detail);
        $this->display();
    }
}