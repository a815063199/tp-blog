<?php
namespace app\home\model;

use think\Model;
use think\Db;

class Article extends Model
{
    //获取首页的文章
    public function getAllArticle($sizePerPage) {
        $data = $this->field([
            'id',
            'title',
            'author',
            'img_url',
            'summary',
            'tag',
            'create_at',
            'views',
            'comments'])->order('create_at desc')->paginate($sizePerPage);
        return $data;
    }

    public function getOneArticle($id) {
        $art = $this->find($id);
        return $art;
    }


    //获取所有分类
    public function getAllCat() {
        return Db::name('cat')->field(['id', 'cat_name'])->select()->toArray();
    }

    public function getCatName($cat_id) {
        //$res = Db::name('cat')->field(['cat_name'])->where('id', $cat_id)->find();
        //return $res['cat_name'];
        return Db::name('cat')->where('id', $cat_id)->value('cat_name');
    }

    //获取分类文章
    public function getCatArticle($cat_id, $sizePerPage) {
        return $this->where('cat_id', $cat_id)->field([
            'id',
            'title',
            'author',
            'img_url',
            'summary',
            'tag',
            'create_at',
            'views',
            'comments'])->order('create_at desc')->paginate($sizePerPage);
    }

    //增加文章浏览量
    public function addViews($aid) {
        $this->where('id', $aid)->setInc('views');
    }

    //获取最近文章
    public function getNewArt() {
        return $this->field(['title', 'id'])->order('create_at DESC')->limit(10)->select()->toArray();
    }

    //获取热门标签
    public function getHotTag() {
        $res = $this->order('views DESC')->limit(10)->column('tag');
        return array_unique($res);
    }

    //随机获取4条同一分类的文章
    public function getRandArticle($aid) {
        $cid = $this->where('id', $aid)->value('cat_id');
        $res = $this->where('cat_id', $cid)->field(['id', 'img_url', 'title'])->order('rand()')->limit(4)->select()->toArray();
        return $res;
    }

    //获取上一篇文章
    public function getPreArticle($aid) {
        $res = $this->where('id', '<', $aid)->field(['id', 'title'])->limit(1)->find();
        if ($res) {
            return $res->toArray();
        } else {
            return $res="没有上一篇文章了";
        }
    }

    //获取下一篇文章
    public function getNextArticle($aid) {
        $res = $this->where('id', '>', $aid)->field(['id', 'title'])->limit(1)->find();
        if ($res) {
            return $res->toArray();
        } else {
            return $res="没有下一篇文章了";
        }
    }

    //获取所有幻灯片
    public function getAllPic() {
        return Db::name('pic')->where('is_show', '=', 1)->select()->toArray();
    }

    //获取所有友情链接
    public function getAllLink() {
        return Db::name('link')->order('order_by')->select();
    }

    //获取系统设置
    public function getSys() {
        return Db::name('sys')->find();
    }

    //文章评论数+1
    public function IncComments($id) {
        $this->where('id', $id)->setInc('comments');
    }

    public function getTopCommentArticle() {
        return $this->field(['id', 'title', 'img_url'])->order('comments desc')->limit(4)->select()->toArray();
    }
}
