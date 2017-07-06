<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/6
 * Time: 12:00
 */

namespace Admin\Controller;

class SaleController extends AdminController
{
        public function index(){
            $name       =   I('name');
            $map['status']  =   array('egt',0);
            if(is_numeric($name)){
                $map['id|name']=   array(intval($name),array('like','%'.$name.'%'),'_multi'=>true);
            }else{
                $map['name']    =   array('like', '%'.(string)$name.'%');
            }
            $list   = $this->lists('Sale', $map);
            function int_to_string(&$data,$map=array('status'=>array(1=>'正常',-1=>'删除',0=>'禁用',2=>'未审核',3=>'草稿'),'type'=>array(0=>'出租',1=>'售卖'),'unit'=>array(0=>'元/月',1=>'万元'))) {
                if($data === false || $data === null ){
                    return $data;
                }
                $data = (array)$data;
                foreach ($data as $key => $row){
                    foreach ($map as $col=>$pair){
                        if(isset($row[$col]) && isset($pair[$row[$col]])){
                            $data[$key][$col.'_text'] = $pair[$row[$col]];
                        }
                    }
                }
                return $data;
            }
            int_to_string($list);
            $this->assign('_list', $list);
            $this->meta_title = '租售信息';
            $this->display();
         }
    public function add(){
        if(IS_POST){
            $Sale = D('Sale');
            $data = $Sale->create();
            if($data){
                $id = $Sale->add();
                if($id){
                    $this->success('新增成功', U('index'));
                    //记录行为
                    action_log('update_sale', 'sale', $id, UID);
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($Sale->getError());
            }
        } else {
            $this->assign('info',null);
            $this->meta_title = '新增租售信息';
            $this->display('edit');
        }
    }
    public function edit($id=0){
        if(IS_POST){
            $Sale = D('Sale');
            $data = $Sale->create();
            if($data){
                if($Sale->save()){
                    //记录行为
                    action_log('update_sale', 'sale', $data['id'], UID);
                    $this->success('编辑成功', U('index'));
                } else {
                    $this->error('编辑失败');
                }

            } else {
                $this->error($Sale->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = M('Sale')->find($id);

            if(false === $info){
                $this->error('获取配置信息错误');
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑导航';
            $this->display();
        }
    }
    public function del($id=0){
        $id = array_unique((array)I('id',0));

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id) );

        if($this->delete('Sale',$map)){
            session('ADMIN_MENU_LIST',null);
            //记录行为
            action_log('update_sale', 'Sale', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }
    /**
     * 租售状态修改
     */
    public function changeStatus($method=null){
        $id = array_unique((array)I('id',0));
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map['id'] =   array('in',$id);
        switch ( strtolower($method) ){
            case '0':
                $this->forbid('Sale', $map );
                break;
            case '1':
                $this->resume('Sale', $map );
                break;
            case '-1':
                $this->delete('Sale', $map );
                break;
            default:
                $this->error('参数非法');
        }
    }
}