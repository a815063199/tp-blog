<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Config;
use think\Image;

class uploadController extends Controller
{
    //上传文章图片缩略图
    public function uploadArt(Request $request) {
        $validate = Config::get('image.VALIDATE');
        $path = Config::get('image.ARTPATH');
        $file = $request->file('file');
        $res = $file->validate($validate)->move($path);
        if ($res) {
            $fileName = $res->getPathName();
            $image = Image::open($fileName);
            $image->thumb(250, 150, Image::THUMB_FIXED)->save($fileName);
            $data = ['status' => 'success', 'info' => $fileName];
        } else {
            $data = ['status' => 'fail', 'info' => $file->getError()];
        }
        return json($data);
    }

    //上传幻灯片
    public function uploadPic(Request $request) {
        $validate = Config::get('image.VALIDATE');
        $path = Config::get('image.PICPATH');
        $file = $request->file('file');
        $res = $file->validate($validate)->move($path);
        if ($res) {
            $fileName = $res->getPathName();
            $image = Image::open($fileName);
            $image->thumb(920, 300, Image::THUMB_FIXED)->save($fileName);
            $data = ['status' => 'success', 'info' => $fileName];
        } else {
            $data = ['status' => 'fail', 'info' => $file->getError()];
        }
        return json($data);
    }
}
