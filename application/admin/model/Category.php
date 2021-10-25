<?php

namespace app\admin\model;

use think\Model;
use think\Db;

class Category extends Model
{
    //指定表名，非默认的Category
    protected $table='blog_cat';
    //添加分类
    public function addCat($cat_name, $cat_desc) {
        $data = ['cat_name' => $cat_name, 'cat_desc' => $cat_desc];
        if ($this->save($data)) {
            $res = ['status' => 'success', 'info' => '分类添加成功'];
        } else {
            $res = ['status' => 'fail', 'info' => '分类添加失败'];
        }
        return $res;
    }

    //获取所有分类
    public function getAllCat() {
        return $this->select()->toArray();
    }

    //获取指定分类
    public function getOneCat($id) {
        return $this->find($id)->toArray();
    }

    //更新分类
    public function updateCat($id, $data) {
        if ($this->where('id', $id)->update($data)) {
           $res = ['status' => 'success', 'info' => '分类更新成功']; 
        } else {
           $res = ['status' => 'fail', 'info' => '分类更新失败']; 
        }
        return $res;
    }
    //删除分类
    public function deleteCat($id) {
        $data = Db::name('article')->where('cat_id', $id)->find();
        if ($data) {
           $res = ['status' => 'fail', 'info' => '分类下还有文章']; 
           return $res;
        }

        if ($this->where('id', $id)->delete()) {
           $res = ['status' => 'success', 'info' => '分类删除成功']; 
        } else {
           $res = ['status' => 'fail', 'info' => '分类删除失败']; 
        }
        return $res;
    }
    //获取分类总条数
    public function getAllCatCount() {
        return $this->count();
    }
}
