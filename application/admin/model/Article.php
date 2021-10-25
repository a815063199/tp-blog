<?php

namespace app\admin\model;

use think\Model;

class Article extends Model
{
    //自动写时间戳
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_at';
    protected $updateTime = 'update_at';

    public function addArt($data) {
        if ($this->save($data)) {
            $res = ['status' => 'success', 'info' => '文章发布成功'];
        } else {
            $res = ['status' => 'fail', 'info' => '文章发布失败'];
        }
        return $res;
    }

    //获取所有文章
    public function getAllArticle($size_per_page) {
        $data = $this->alias('a')->field('a.id,a.title,a.views,a.create_at,c.cat_name')->join('cat c', 'a.cat_id = c.id', 'inner')->order('create_at desc')->paginate($size_per_page);
        return $data;
    }

    //获取文章数量
    public function getArticleCount() {
        return $this->alias('a')->field('a.id')->join('cat c', 'a.cat_id = c.id', 'inner')->count();
    }

    //获取指定文章
    public function getOneArticle($id) {
        //true:排除字段
        $data = $this->field(['views', 'update_at', 'create_at'], true)->find($id)->toArray();
        return $data;
    }

    //更新文章
    public function updateArticle($data, $id) {
        if ($this->where('id', $id)->update($data)) {
            $res = ['status' => 'success', 'info' => '更新成功'];
        } else {
            $res = ['status' => 'fail', 'info' => '更新失败'];
        }
        return $res;
    }

    //删除文章
    public function deleteArticle($id) {
        if ($this->where('id', $id)->delete()) {
            $res = ['status' => 'success', 'info' => '删除成功'];
        } else {
            $res = ['status' => 'fail', 'info' => '删除失败'];
        }
        return $res;
    }
}
