<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\model;

use app\common\model\Base;
use think\Db;

class ThreadColumn extends Base {

    

    public function model_where() {

        $db = db('thread_column');

        if (request()->get('keyword'))
            $db->where('title', 'like', '%' . request()->get('keyword') . '%');

        $db->order('id desc');

        return $db;
    }

}
