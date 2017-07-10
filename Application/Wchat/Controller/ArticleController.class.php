<?php
namespace Wchat\Controller;

use Think\Controller;
use Think\Page;

class ArticleController extends WechatController
{
    private $category_config = [
        'notice',
        'service',
        'shop',
        'activity'
    ];

    /**
     * 详细信息
     * @param unknown $id
     */
    public function detail($id) {
        if(!is_numeric($id)){
            $this->error("参数错误!");
        }
        $Document = D("Document");
        $notice_info = $Document->detail($id);
        /* 查看数量增加 */
        $Document->addView($id);
        $notices=$notice_info;
        $this->assign("notices",$notices);
    }
    public function articleList($p = 1,$cat_type){
        //参数验证
        if(!is_numeric($p) || !in_array($cat_type, $this->category_config)){
            $this->error("参数错误！");
        }

        $cache_name = CONTROLLER_NAME.'_'.md5(ACTION_NAME).'_'.$p;
        $list = S($cache_name);
        if(!$list){
            //获取分类信息
            $category = $this->category($cat_type);

            /* 获取当前分类列表 */
            $Document = D('Document');
            $list = $Document->where(['status'=>1])->page($p, $category['list_row'])->lists($category['id']);

            if(empty($list)){
                $this->error("没有了！");
            }
            /**
             * 拿到封面
             */
            foreach ($list as $key=>$vo){
                $cover = M('picture')->field('path')->find($vo['cover_id']);
                $list[$key]['path'] = $cover['path'];
                $list[$key]['create_time'] = date("Y-m-d H:i",$vo['create_time']);
            }
            S($cache_name,$list);
        }
        if(IS_AJAX){
            $this->ajaxReturn(ajaxData(1,'获取数据成功！',$list));
            exit;
        }
//        //获取数据总条数据
//        $count = $Document->getCount($category['id']);
//        //分页
//        $page = new Page($count,$category['list_row']);
//        $pageHtml = $page->show();
        $notices=$list;
        $this->assign('notices',$notices);
//        $this->assign('pageHtml',$pageHtml);
    }
    
    
    private function category($cat_type){
        $cat_id =  M('category')->where(['name'=>$cat_type])->getField('id');
        if(empty($cat_id)){
            $this->error('没有指定文档分类！');
        }
        /* 获取分类信息 */
        $category = M('Category')->find($cat_id);
        if($category && 1 == $category['status']){
            switch ($category['display']) {
                case 0:
                    $this->error('该分类禁止显示！');
                    break;
                    //TODO: 更多分类显示状态判断
                default:
                    return $category;
            }
        } else {
            $this->error('分类不存在或被禁用！');
        }
    }
}

?>