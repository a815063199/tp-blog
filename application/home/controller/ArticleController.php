<?php
namespace app\home\controller;

use app\home\controller\BaseController;
use app\home\model\Article;
use think\Request;
use Predis\Client as Redis;
use think\Config;

class ArticleController extends BaseController
{
    public function listArticle($cid)
    {
        $cat_id = decrypt($cid);
        if ($cat_id == '') {
            return $this->error('没有此分类', '/');
        }
        $article = new Article;
        $articles = $article->getCatArticle($cat_id, 1);
        $this->assign('articles', $articles);
        $cat_name = $article->getCatName($cat_id);
        $this->assign('cat_name', $cat_name);
        $this->assign('cat_id', $cat_id);
        return $this->fetch('list');
    }

    public function detailArticle($aid)
    {
        $decode_aid = decrypt($aid);
        if ($decode_aid == '') {
            return $this->error('没有此文章', '/');
        }
        $art = new Article;
        $article = $art->getOneArticle($decode_aid);
        $rand_article = $art->getRandArticle($decode_aid);
        $pre_article = $art->getPreArticle($decode_aid);
        $next_article = $art->getNextArticle($decode_aid);
        //获取评论
        $config = Config::get('redis');
        $redis = new Redis($config);
        $key = 'article-' . $decode_aid;
        $comments = $redis->SMEMBERS($key);
        if ($comments != null) {
            $comment = $this->doComments($comments);
        } else {
            $comment = '此文章没有人评论';
        }
        $this->assign('comments', $comment);
        $this->assign('article', $article);
        $this->assign('rand_article', $rand_article);
        $this->assign('pre_article', $pre_article);
        $this->assign('next_article', $next_article);
        //增加游览量
        $art->addViews($decode_aid);
        return $this->fetch('detail');
    }

    public function comment(Request $request) {
        $validate = validate('userValidate');
        $check = $request->only(['__token__', 'captcha']);
        if (!$validate->check($check)) {
            return $this->error($validate->getError());
        }
        $time = time();
        $comments = $request->param('comments', '', 'htmlspecialchars,trim');
        $id = $request->param('id');
        $config = Config::get('redis');
        $redis = new Redis($config);
        $key = 'article-' . $id;
        $value = $comments . '==|==' . $time;
        $res = $redis->SADD($key, $value);
        if (!$res) {
            return $this->error('评论失败');
        }
        $art = new Article;
        $art->IncComments($id);
        return $this->success('评论成功');
    }

    public function doComments($data) {
        foreach ($data as $v) {
            list($contents, $time) = explode('==|==', $v);
            $newCom[$time] = $contents;
        }
        krsort($newCom);
        return $newCom;
    }
}
