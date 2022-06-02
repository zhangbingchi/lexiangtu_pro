<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\model;

use app\common\model\Base;
use think\Db;

class Thread extends Base {

    protected $deleteTime = 'delete_time';

    public function thread_edit($post) {

        $id = $post['id'] ?? 0;

        $data['cid'] = $post['cid'] ?? '';
        $data['title'] = $post['title'] ?? '';
        $data['content'] = $post['content'] ?? '';
        $data['points'] = $post['points'] ?? '';
        $data['update_time'] = time();
        $data['member_id'] = session('member.id');

        if ($id) {

            return db('thread')->where('id', $id)->update($data);
        } else {

            return 'ID缺失';
        }
    }

    public function thread_add($post) {
        $data['cid'] = $post['cid'] ?? '';
        $data['title'] = $post['title'] ?? '';
        $data['content'] = $post['content'] ?? '';
        $data['points'] = $post['points'] ?? '';
        $data['status'] = 0;
        $data['create_time'] = time();
        $data['update_time'] = time();
        $data['member_id'] = session('member.id');

         

        // 
        $insert_id = db('thread')->insertGetId($data);

        return $insert_id;
    }

    public function model_where($wheres = []) {
        $db = db('thread');
        foreach ($wheres as $key => $value) {
            $db->where($value[0], $value[1], $value[2]);
        }

        if ($keyword = request()->get('keyword'))
            $db->where('a.title', 'like', '%' . $keyword . '%');

        $db->join('member m', 'm.id = a.member_id', 'LEFT');
        $db->join('member_ident mi', 'mi.member_id = m.id', 'LEFT');
        if (isset($wheres['thread_tags'])) {
            $db->join('thread_tags t', 't.article_id = a.id', 'LEFT');
        }
        $db->alias('a');

        $db->order('a.top desc,a.id desc');

        $db->field('a.*,m.id as member_id,m.nickname,m.avatar,m.sex,m.vip,m.ident,mi.identification');

        return $db;
    }
}
