<?php

namespace app\common\model;

use think\Model;
use app\common\model\Base;

class Nav extends Base {

    
    public function getCategoryNameAttr($value, $data) {
        return db('nav_cat')->where('id', $data['cid'])->value('title');
    }

    public function model_where() {
        $db = db('nav');

        if (request()->get('keyword'))
            $db->where('title', 'like', '%' . request()->get('keyword') . '%');


        if (request()->get('category'))
            $db->where('cid', request()->get('category'));


        $db->order('listorder asc,id desc');
        
        return $db;
    }

}
