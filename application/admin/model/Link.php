<?php

namespace app\admin\model;

use think\Model;

class Link extends Model
{
    //添加友情链接
    public function addLink($data) {
        if ($this->save($data)) {
            $res = ['status' => 'success', 'info' => '友情链接添加成功'];
        } else {
            $res = ['status' => 'fail', 'info' => '友情链接添加失败'];
        }
        return $res;
    }

    //获取所有的友情链接
    public function getAllLink() {
        return $this->select()->toArray();
    }

    //获取一条友情链接
    public function getOneLink($id) {
        return $this->where('id', $id)->find()->toArray();
    }

    //修改链接
    public function updateLink($id, $data) {
        if ($this->where('id', $id)->update($data)) {
            $res = ['status' => 'success', 'info' => '友情链接修改成功'];
        } else {
            $res = ['status' => 'fail', 'info' => '友情链接修改失败'];
        }
        return $res;
    }

    //删除链接
    public function deleteLink($id) {
        if ($this->where('id', $id)->delete()) {
            $res = ['status' => 'success', 'info' => '友情链接删除成功'];
        } else {
            $res = ['status' => 'fail', 'info' => '友情链接删除失败'];
        }
        return $res;
    }
}
