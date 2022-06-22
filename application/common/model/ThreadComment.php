<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\model;

use app\common\model\Base;
use think\Db;

class ThreadComment extends Base {

    // 回复点赞
    public function thread_comment_zan($thread_comment_id, $member_id, $ok) {
        $data['member_id'] = $member_id;
        $data['thread_comment_id'] = $thread_comment_id;
        $data['create_time'] = time();

        Db::startTrans();
        try {
            if ($ok == 'true') {
                // 取赞
                db('thread_comment_hits_zan')->where('member_id', $member_id)->where('thread_comment_id', $thread_comment_id)->delete();
                db('thread_comment')->where('id', $thread_comment_id)->setDec('like');
            } else {
                db('thread_comment_hits_zan')->insert($data);
                db('thread_comment')->where('id', $thread_comment_id)->setInc('like');
            }
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return $e->getMessage();
        }
    }

    /**
     * 帖子回复
     * @param type $post
     */
    public function thread_comment_add($post) {
        $data['thread_id'] = $post['thread_id'];
        $data['content'] = $post['content'];
        $data['member_id'] = session('member.id');
        $data['create_time'] = time();

        Db::startTrans();
        try {
            db('thread_comment')->insertGetId($data);
            // 帖子的回复数要+1
            db('thread')->where('id', $data['thread_id'])->setInc('comment');
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return $e->getMessage();
        }
    }

    public function model_where($where) {
        $db = db('thread_comment');

        foreach ($where as $value) {
            $db->where($value[0], $value[1], $value[2]);
        }

        if (request()->get('keyword'))
            $db->where('a.content', 'like', '%' . request()->get('keyword') . '%');

        $db->join('member m', 'm.id = a.member_id', 'LEFT');
        $db->join('thread t', 't.id = a.thread_id', 'LEFT');
        $db->where('t.is_delete', '0');
        $db->alias('a');
        $db->order('a.is_take desc,a.id desc');
        $db->field('a.*,m.id as member_id,m.nickname,m.avatar,m.sex,t.title,t.article_id');
        return $db;
    }

}
