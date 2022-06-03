<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\model;

use app\common\model\Base;
use think\Db;

class ThreadColumnMember extends Base {

    public function model_where() {

        $db = db('thread_column_member');

        if (request()->get('keyword'))
            $db->where('m.nickname', 'like', '%' . request()->get('keyword') . '%');


        $db->join('member m', 'm.id = a.member_id');

        $db->alias('a');

        $db->order('a.id desc');

        $db->field('a.*,m.nickname');


        return $db;
    }

}
