<?php
namespace Wchat\Model;

use Think\Model;

class DocumentModel extends Model
{

    public function addView($id)
    {
        if (is_numeric($id) && $id > 0) {
            $this->where(['id' => $id])->setInc("view");
        }
    }

    /**
     * 获取详情页数据
     * @param  integer $id 文档ID
     * @return array       详细数据
     */
    public function detail($id)
    {
        /* 获取基础数据 */
        $info = $this->alias('d')->field(['me.nickname,d.*,da.*'])
            ->join("document_article as da on d.id=da.id")
            ->join("member as me on d.uid=me.uid")
            ->where(['d.id' => $id])
            ->find();
        if (!(is_array($info) || 1 !== $info['status'])) {
            $this->error = '文档被禁用或已删除！';
            return false;
        }
        return $info;
    }


    /**
     * 获取文档列表
     * @param  integer $category 分类ID
     * @param  string $order 排序规则
     * @param  integer $status 状态
     * @param  boolean $count 是否返回总数
     * @param  string $field 字段 true-所有字段
     * @return array              文档列表
     */
    public function lists($category, $order = '`id` DESC', $status = 1, $field = true)
    {
        $map = $this->listMap($category, $status);
        
        return $this->field($field)->where($map)->order($order)->select();;
    }

    /**
     * 获取总条数
     * @param $category
     * @param int $status
     * @return mixed
     */
    public function getCount($category,$status = 1){
        $map = $this->listMap($category, $status);
        $count = $this->where($map)->count();
        return $count;
    }
    /**
     * 设置where查询条件
     * @param  number $category 分类ID
     * @param  number $pos 推荐位
     * @param  integer $status 状态
     * @return array             查询条件
     */
    private function listMap($category, $status = 1, $pos = null)
    {
        /* 设置状态 */
        $map = array('status' => $status, 'pid' => 0);

        /* 设置分类 */
        if (!is_null($category)) {
            if (is_numeric($category)) {
                $map['category_id'] = $category;
            } else {
                $map['category_id'] = array('in', str2arr($category));
            }
        }

        $map['create_time'] = array('lt', NOW_TIME);
        $map['_string'] = 'deadline = 0 OR deadline > ' . NOW_TIME;

        /* 设置推荐位 */
        if (is_numeric($pos)) {
            $map[] = "position & {$pos} = {$pos}";
        }

        return $map;
    }

}

?>