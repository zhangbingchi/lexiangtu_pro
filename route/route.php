<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 完整域名绑定到admin模块
Route::domain('admin.lexiangtu.top', 'admin');

Route::domain('test.lexiangtu.top', 'index');


Route::get('thread/:alias', 'index/thread');

Route::get('thread_views/:id', 'index/thread_views');

// 标签列表
Route::get('tags', 'index/tags');