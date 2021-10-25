<?php
namespace app\home\controller;

use app\home\controller\BaseController;
use app\home\model\Article;

class IndexController extends BaseController
{
    public function index()
    {
        $article = new Article;
        $articles = $article->getAllArticle(3);
        $pics = $article->getAllPic();
        $this->assign('articles', $articles);
        $this->assign('pics', $pics);
        $this->assign('index', 'index');
        return $this->fetch();
    }
}
