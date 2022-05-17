<?php

namespace app\index\controller;

use app\common\controller\Base;
use utils\Page;

class Index extends Base {

    /**
     * @title 论坛首页
     * @return type
     */
    public function index() {
        // 推荐4条
        $wheres = [
            ['a.recommend', '=', 1],
            ['a.is_delete', '=', 0]
        ];
        $lists_top4 = model('thread')->model_where($wheres)->limit(4)->select();
        $this->assign('lists_top4', $lists_top4);


        // 回帖周榜12
        $lists_member12 = model('thread_comment')
                ->alias('a')
                ->where('a.create_time', '>', time() - 604800)
                ->group('a.member_id,m.avatar,m.nickname,m.sex')
                ->field('a.member_id,m.avatar,m.nickname,m.sex,count(a.member_id) as count')
                ->join('member m', 'm.id = a.member_id')
                ->limit(12)
                ->select()->toArray();
        $this->assign('lists_member12', $lists_member12);

        // 综合10条帖子
        $lists_thread20 = model('thread')->model_where([['a.is_delete', '=', 0]])->limit(10)->select();
        $this->assign('lists_thread20', $lists_thread20);

        // 加载签到的初始化状态
        $member = member_is_login();
        $member_id = !empty($member) ? $member['id'] : -1;

        $sign_info = getSignTip($member_id);
        $sign_tip = $sign_info['tip'];

        $canlendars = getCanlendar();
        $start_time = strtotime(date("Y-m-01"));
        $end_time = time();
        $signs = db("member_sign")->field("sign_time")->
        where("member_id", $member_id)->where('sign_time', 'between', [$start_time, $end_time])->select();

        $signs_dates = array();
        foreach ($signs as $v) {
            $signs_dates[] = date("Y-m-d", $v['sign_time']);
        }

        $this->assign("canlendars", $canlendars);
        $this->assign("days", date('t', strtotime("Y-m-1")));
        $this->assign("today", date("Y-m-d"));
        $this->assign("signs_dates", $signs_dates);
        $this->assign("sign_info", $sign_info);
        $this->assign("sign_tip", $sign_tip);

        return view();
    }

    public function tags() {
        $tags = model('tags')->whereIn('tag_type', [1,2,3])->select()->toArray();
        $tags = get_tree($tags);
        return json(['code' => 0, 'data' => $tags]);

    }

    /**
     * @title 论坛栏目查看权限
     * cid 栏目的id
     */
    public function _thread_access($cid) {
        // 权限验证
        $thread_column = db('thread_column')->where('id', $cid)->find();
        // 会员积分和VIP级别
        $member = member_is_login();
        // print_r($member);
        if (!is_array($member)) {
            $vip = 0;
            $points = 0;
        } else {
            $vip = $member['vip'];
            $points = $member['points'];
        }
        // 没有权限，则阻止继续浏览
        if ($thread_column['join_type'] == 1) {
            // 没有达到VIP级别，展示一个无权访问页面
            if ($vip < $thread_column['vip_limit']) {
                return '无法进入该会员专区，至少VIP' . $thread_column['vip_limit'] . '级会员可访问';
            }
        } elseif ($thread_column['join_type'] == 2) {
            if ($points < $thread_column['points_limit']) {
                return '无法进入该会员专区，至少' . $thread_column['points_limit'] . '积分的会员可访问';
            }
        }
    }

    /**
     * @title 帖子列表
     * 进入论坛要验证
     */
    public function thread() {

        // 栏目别名
        $alias = input('param.alias');
        $type = input('param.type');
        $page = input('param.page', 1);


        if ($alias && $alias != 'all') {
            $cid = db('thread_column')->where('alias', $alias)->value('id');
        } else {
            $cid = 0;
        }

        // 浏览权限        
        if ($msg = $this->_thread_access($cid)) {
            return view('user/access_denied', ['msg' => $msg]);
            exit;
        }

        $wheres = [['a.is_delete', '=', 0]];
        if ($cid) {
            $wheres[] = ['a.cid', '=', $cid];
        }
        // 精华
        if ($type == 'wonderful') {
            $wheres[] = ['a.status', '=', 1];
        }
        // 推荐
        $lists = model('thread')->model_where($wheres)->paginate(10, false, ['query' => request()->get()]);
        $this->assign('lists', $lists);

        $count = model('thread')->model_where($wheres)->count();
        $pager = new Page();
        if ($type) {
            $url = url('/column/' . $alias . '/' . $type) . '/page/{page}/';
        } else {
            $url = url('/column/' . $alias) . '/page/{page}/';
        }

        $pager->setUrl($url);
        $pager->setTotal($count);
        $pager->setLimit(10);
        $pager->setPage($page);

        $this->assign('count', $count);
        $this->assign('pager', $pager->render());
        return view();
    }

    /**
     * @title 帖子详情查看
     */
    public function thread_views() {
        $articleId = input('param.id');
        if (!$articleId) exit;

        $wheres = [['a.article_id', '=', $articleId],['a.is_delete', '=', 0]];
        $one = model('thread')->model_where($wheres)->find();
        if(!$one) {
            $this->error('文章已删除～', 'thread/all');
        }

        // 删除 置顶 加精 是否能显示
        $one['display_top'] = 0;
        $one['display_status'] = 0;

        $this->assign($one);
        // 登录状态
        $member = member_is_login();
        if (!empty($member)) {
            $member_id = $member['id'];
            // 用户详情
            $member = model('member')->get($member_id);
        } else {
            $member_id = 0;
            $member = [];
        }

        // 文章详情
        $ingredients = model('thread_ingredients')->where('article_id', '=', $one['article_id'])->select();
        $this->assign('thread_ingredients', $ingredients);

        // 文章标签
        $tags = model('thread_tags')->alias('tt')->field('title')
            ->leftJoin('tags t', 'tt.tags_id=t.id')
            ->where('article_id', '=', $one['id'])
            ->select()->toArray();
        $tags = array_column($tags, 'title');
        $tags = ['ad洒大地', '阿萨说', 'sd收到'];
        $this->assign('thread_tags', $tags);

        // 图片列表
        $threadImages = model('thread_images')->where('article_id', '=', $one['article_id'])->select();
        $this->assign('thread_images', $threadImages);

        // 下载权限
        $levelAuth['member_id'] = $member_id;
        $levelAuth['is_down_auth'] = 0;
        $levelAuth['user_level'] = '未注册';
        $allowCount = 0;
        if ($member_id) {
            $levelAuth['is_down_auth'] = !!(redis()->get("user_preview:{$member_id}:{$articleId}"));
            // 用户等级
            $levelAuth['user_level'] = '普通会员';
            if ($member['user_level'] >= 2 && !empty($memner['level_expire']) && $memner['level_expire'] > time()) {
                $goodsInfo = model('goods')->where('id', '=', $member['user_level'])->get()->select();
                $levelAuth['user_level'] = $goodsInfo['goods_name'];
                $count = redis()->hlen("user_download:{$member_id}:" . date('Ymd'));
                $allowCount = $goodsInfo['day_down_count'] - $count;
                if ($allowCount > 0) {
                    $levelAuth['is_down_auth'] = 1;
                }

                // 视频累年费会员可下载
                if ($one['source_type'] == 1 && $member['user_level'] < 3) {
                    $levelAuth['is_down_auth'] = 0;
                }

            }
        }
        $levelAuth['allow_count'] = $allowCount; // 剩余下载次数
        $this->assign('level_auth', $levelAuth);

        // 回复的列表      
        $where = [
            ['a.thread_id', '=', $one['id']]
        ];
        $lists_comment = model('thread_comment')->model_where($where)->paginate(10, false, ['query' => request()->get()])->toArray();
        if (!empty($lists_comment['data'])) {
            foreach ($lists_comment['data'] as &$value) {
                // 评论的 编辑 删除 采纳 是否能显示
                $value['display_comment_edit'] = ($member_id == $one['member_id'] || $member_id == $value['member_id']) ? 1 : 0;
                $value['display_comment_del'] = ($member_id == $one['member_id'] || $member_id == $value['member_id']) ? 1 : 0;
                $value['display_comment_accept'] = ($member_id == $one['member_id']) ? 1 : 0;
            }
        }
        $this->assign('lists_comment', $lists_comment);

        return view();
    }

    /**
     * @title 帖子评论的添加 
     * 前置条件：登录后
     */
    public function thread_comment_add() {

        if (is_array($member = member_is_login())) {

            //
            $post = request()->post();
            if (empty($post['thread_id'])) {
                $this->error('找不到帖子');
            }

            //
            //print_r($member_id);
            $msg = model('thread_comment')->thread_comment_add($post);
            if (is_numeric($msg) || empty($msg)) {
                // 发布成功 ，跳转到所属的帖子
                $this->success('发布成功', url('/thread/' . $post['thread_id']));
            } else {
                $this->error($msg);
            }
        } else {
            $this->error('请登录后进行操作');
        }
    }

}
