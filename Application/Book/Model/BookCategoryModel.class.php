<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-5-28
 * Time: 下午1:50
 * @author 郑钟良<zzl@ourstu.com>
 */

namespace Book\Model;


use Think\Model;

class BookCategoryModel extends Model
{

    protected $_auto = array(
        array('status', '1', self::MODEL_INSERT),
    );


    /**
     * 获取分类详细信息
     * @param $id
     * @param bool $field
     * @return mixed
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function info($id, $field = true)
    {
        /* 获取分类信息 */
        $map = array();
        if (is_numeric($id)) { //通过ID查询
            $map['id'] = $id;
        } else { //通过标识查询
            $map['name'] = $id;
        }
        return $this->field($field)->where($map)->find();
    }

    public function editData()
    {
        $data = $this->create();
        if ($data['id']) {
            $res = $this->save($data);
        } else {
            $res = $this->add($data);
        }
        return $res;
    }

    /**
     * 获得分类树
     * @param int $id
     * @param bool $field
     * @param array $map
     * @return array|mixed
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function getTree($id = 0, $field = true, $map = array('status' => array('gt', -1)))
    {
        /* 获取当前分类信息 */
        if ($id) {
            $info = $this->info($id);
            $id = $info['id'];
        }

        /* 获取所有分类 */
        $list = $this->field($field)->where($map)->order('sort desc')->select();
        $list = list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_', $root = $id);

        /* 获取返回数据 */
        if (isset($info)) { //指定分类则返回当前分类极其子分类
            $info['_'] = $list;
        } else { //否则返回所有分类
            $info = $list;
        }
        return $info;
    }

    public function getCategoryList($map=array(),$type=0)
    {
        $list=$this->where($map)->field('id,title,pid,sort,status')->order('sort desc')->select();
        if(!$type){
            return $list;
        }
        $father_list=$child_list=array();
        foreach($list as $val){
            if($val['pid']==0){
                $father_list[]=$val;
            }else{
                $val['title']='[子分类]'.$val['title'];
                $child_list[]=$val;
            }
        }
        $cateList=array();
        foreach($father_list as $val){
            $cateList[]=$val;
            foreach($child_list as $tt){
                if($tt['pid']==$val['id']){
                    $cateList[]=$tt;
                }
            }
        }
        return $cateList;
    }
} 