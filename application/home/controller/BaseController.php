<?php

namespace app\home\controller;

use think\Controller;
use app\home\model\Article;
use think\View;

class BaseController extends Controller
{
    public function _initialize() {
        $article = new Article;
        $cats = $article->getAllCat();
        $new_art = $article->getNewArt();
        $hot_tags = $article->getHotTag();
        $links = $article->getAllLink();
        $sys = $article->getSys();
        $topCommentArticle = $article->getTopCommentArticle();
        //继承该类的所有子类视图共享cats
        View::share('cats', $cats);
        View::share('new_art', $new_art);
        View::share('hot_tags', $hot_tags);
        View::share('links', $links);
        View::share('sys', $sys);
        View::share('top_comment_articles', $topCommentArticle);
    }
}
