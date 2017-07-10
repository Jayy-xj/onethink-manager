<?php
namespace Admin\Controller;

use Think\Page;

class CenterController extends AdminController
{

    /**
     * 报修管理
     */
    public function index(){
        $this->meta_title = "管理中心";

        $keywords = trim(I('keywords'));

        $map['status'] = ['gt',-1];

        if(!empty($keywords)){
            $map['_string']    =   "(name like '%{$keywords}%' or sn like '{$keywords}%')";
        }

        $repair_list = $this->lists('Repair',$map);
        
        $this->assign('_list',$repair_list);
        $this->display();
    }

    /**
     * 活动管理
     */
    public function activity($p=1){

        $this->meta_title = "管理中心";

        $map[] = 'a.status >= 0';
        $map[] = 'a.type = 43';
        $where = implode(" and ",$map);

        $pageSize = C("LIST_ROWS");

        //分页
        $total = M('Apply')->count();
        $page = new Page($total,$pageSize);

        $p =$page->show();
        $this->assign('_page', $p? $p: '');
        $start = $page->firstRow;
        $sql = <<<SQL
            SELECT
                a.id,
                a.uid,
                a.add_time,
                a.`status`,
                d.title,

                m.nickname,
        d.description
            FROM
                `onethink_apply` AS a
            LEFT JOIN onethink_document AS d ON d.id = a.act_id
            LEFT JOIN onethink_member AS m ON a.uid = m.uid
            WHERE {$where} 
            ORDER BY a.add_time DESC 
            LIMIT {$start},{$pageSize}
SQL;


        $list = M()->query($sql);

        $this->assign('_list',$list);
        $this->assign('_total',$total);
        $this->display();
    }

}

?>