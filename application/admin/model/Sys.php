<?php

namespace app\admin\model;

use think\Model;

class Sys extends Model
{
    public function getSys() {
        return $this->find();
    }

    public function updateSys($id, $data) {
        if ($this->where('id', $id)->update($data)) {
            $res = ['status' => 'success', 'info' => '修改系统设置成功'];
        } else {
            $res = ['status' => 'fail', 'info' => '修改系统设置失败'];
        }
        return $res;
    }
}
