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

// 文章列表
Route::get('thread/:alias/:k_id', 'index/thread');
Route::get('thread/:alias', 'index/thread');
// 文章详情
Route::get('thread_views/:id', 'index/thread_views');
// 文章下载
Route::get('thread_down/:id', 'index/thread_down');
// 标签列表
Route::get('tags', 'index/tags');
// 会员中心
Route::get('vip_center', 'order/vip_center');
// 下订单
Route::get('order/purchase/:id', 'order/purchase');
