<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\controller\BaseController;
use app\admin\model\Category;
use app\admin\model\Article;

class ArticleController extends BaseController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $article = new Article;
        //每页显示3条
        $articles = $article->getAllArticle(3);
        $article_count = $article->getArticleCount();
        $this->assign('articles', $articles);
        $this->assign('article_count', $article_count);
        return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $category = new Category;
        $cats = $category->getAllCat();
        if (!$cats) {
            return $this->redirect('/admin/cat');
        }
        $this->assign('cats', $cats);
        return $this->fetch('add');//找 add.html
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data = $request->except(['file']);
        $article = new Article;
        $res = $article->addArt($data);
        if ($res['status'] == 'fail') {
            return $this->error($res['info'], '/admin/article');
        }
        return $this->success($res['info'], '/admin/article');
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $category = new Category;
        $cats = $category->getAllCat();
        $this->assign('cats', $cats);

        $article = new Article;
        $art = $article->getOneArticle($id);
        $this->assign('art', $art);
        return $this->fetch();
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except(['_method', 'file']);
        $article = new Article;
        $res = $article->updateArticle($data, $id);
        if ($res['status'] == 'fail') {
            return $this->error($res['info'], '/admin/article');
        }
        return $this->success($res['info'], '/admin/article');
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $article = new Article;
        $res = $article->deleteArticle($id);
        return json($res);
    }
}
