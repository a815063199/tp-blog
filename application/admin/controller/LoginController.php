<?php
namespace app\admin\controller;
use think\Controller;
use think\captcha\Captcha;
use think\Config;
use think\Request;
use app\admin\model\Admin;
use think\Session;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isPost())
        {
            $validate = validate('UserValidate');
            $check = $request->only(['captcha', '__token__']);
            if (!$validate->check($check))
            {
                return $this->error($validate->getError(), '/admin/login');
            }
            $username = $request->param('username', 'trim');
            $password = $request->param('password', 'trim');
            $admin = new Admin;
            $res = $admin->checkLogin($username, $password);
            if ($res['status'] == 'fail') {
                return $this->error($res['info'], '/admin/login');
            }
            Session::set('username', $username);
            return $this->success($res['info'], '/admin/index');
        }
        else if ($request->isGet())
        {
            return $this->fetch();
        }
    }

    public function captcha()
    {
        $config = Config::get('captcha');
        $captcha = new Captcha($config);
        return $captcha->entry();
    }

    public function logout()
    {
        Session::delete('username');
        return $this->redirect('/admin/login');
    }

}
