<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\controller\BaseController;

class IndexController extends BaseController
{
    public function index()
    {
        //打印系统信息
        //dump($_SERVER);
        return $this->fetch();//默认找index.html
    }

    public function welcome()
    {
        return $this->fetch();//默认找welcome.html
    }
}
