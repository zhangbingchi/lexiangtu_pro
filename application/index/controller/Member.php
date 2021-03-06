<?php

namespace app\index\controller;

use app\common\controller\Base;
use think\App;

class Member extends Base {

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->_initialize();
    }

    protected function _initialize() {

        parent::_initialize();

        // 前台登录的判断         
        $member = member_is_login();
        $member_id = (is_array($member)) ? $member['id'] : -1;
        define('MID', $member_id);

        if (MID < 0) {
            $server = request()->server();
            $redirect = $server['PATH_INFO'] ?? '';
            $this->error('请登录', url('/user/login', ['redirect' => $redirect]));
            exit;
        }
    }

    /**
     * @title 邮箱激活
     */
    public function activate() {
        $member = db('member')->where('id', MID)->find()->toArray();

        $this->assign($member);

        return view();
    }

    // 基本设置
    public function setting() {

        $member = model('member')->where('id', MID)->find()->toArray();
        $this->assign($member);
        return view();
    }

    /**
     * @title 关注/粉丝
     */
    public function follow($type = 0) {

        empty($type) && exit();

        if ($type == 1) {

            $lists = model('member_follow')->follows_where(MID)->paginate(10, false, ['query' => request()->get()]);
            $count = model('member_follow')->follows_where(MID)->count();

            // 附加 关注的状态字段
            foreach ($lists as $key => $value) {
                $lists[$key]['follow_type'] = model('member_follow')->follow_type($value['id'], MID);
            }

            $this->assign('lists', $lists);
            $this->assign('count', $count);
        } elseif ($type == 2) {
            $lists = model('member_follow')->fans_where(MID)->paginate(10, false, ['query' => request()->get()]);
            $count = model('member_follow')->fans_where(MID)->count();

            // 附加 关注的状态字段
            foreach ($lists as $key => $value) {
                $lists[$key]['follow_type'] = model('member_follow')->follow_type($value['id'], MID);
            }

            $this->assign('lists', $lists);
            $this->assign('count', $count);
        }

        return view();
    }

    /**
     * @title 加关注
     * @method post
     * @params id 1 偶像的ID
     * 自己不能关注自己
     * 关注一个有效的用户
     * 已关注了再次搜索是取消关注
     */
    public function follow_add() {

        $member_id = request()->post('member_id');

        $check_user = model('member')->where('id', $member_id)->find();
        if (empty($check_user)) {
            return ['code' => 1, 'msg' => '关注的用户不存在'];
        }

        if ($member_id != MID) {

            $msg = model('member')->follow_add($member_id, MID);
            if (is_numeric($msg)) {
                return ['code' => 0, 'msg' => 'success', 'data' => $msg];
            } else {
                return ['code' => 1, 'msg' => $msg];
            }
        } else {
            return ['code' => 1, 'msg' => '不能关注自己'];
        }
    }

    /**
     * @title 每日签到(异步)
     * {code: 0, msg: "连续签到1天奖励6积分", days: 1, points: 6, sign_tip: "明日签到可领 6 积分"}
     */
    public function sign_day() {

        $data['member_id'] = MID; //你自己的当前uid
        $data['sign_time'] = strtotime(date("Y-m-d 00:00:00"));
        $data['create_time'] = time();
        $data['sign_ip'] = get_client_ip();

        $yesterday_start = $data['sign_time'] - 3600 * 24;
        $yesterday_end = $data['sign_time'] - 1;
        $yesterday_info = db('member_sign')->field("num")->where('member_id', $data['member_id'])->where('sign_time', 'between', [$yesterday_start, $yesterday_end])->find();

        $data['num'] = $yesterday_info['num'] > 0 ? $yesterday_info['num'] + 1 : 1; //已连续签到

        $info = db('member_sign')->field("id")->where('sign_time', $data['sign_time'])->where('member_id', $data['member_id'])->find();
        if (empty($info)) {

            // $data['points'] = $data['num'] >= 4 ? 12 : 6; //连续签到3天以上获取6积分

            if ($data['num'] >= 30) {
                $data['points'] = 20;
            } elseif ($data['num'] >= 15) {
                $data['points'] = 15;
            } elseif ($data['num'] >= 5) {
                $data['points'] = 10;
            } else {
                $data['points'] = 5;
            }

            $insert_id = db('member_sign')->insertGetId($data);
            if ($insert_id > 0) {

                // 会员表+积分
                db('member')->where('id', MID)->setInc('points', $data['points']);

                // 更新session
                model('member')->session_update(MID);

                $sign_info = getSignTip(MID);
                $sign_tip = $sign_info['tip'];
                return ["code" => 0, "msg" => "连续签到" . $data['num'] . "天奖励" . $data['points'] . "积分", 'data' => ["days" => $data['num'], "points" => $data['points'], "sign_tip" => $sign_tip]];
            }
        } else {
            return ["code" => 1, "msg" => '今日已签到'];
        }
    }

    /**
     * @title 查看当前帖子是否被收藏
     */
    public function wish_find() {

        $thread_id = request()->post('thread_id');
        $member_id = MID;
        empty($thread_id || $member_id) && $this->error('不存在的帖子');

        //
        $count = db('member_wish_thread')->where('member_id', $member_id)->where('thread_id', $thread_id)->count();
        if ($count) {
            return json(['code' => 0, 'msg' => '', 'data' => [
                    'collection' => 1
            ]]);
        } else {
            return json(['code' => 0, 'msg' => '', 'data' => [
                    'collection' => 0
            ]]);
        }
    }

    /**
     * @title 收藏帖子
     */
    public function wish_add() {
        $thread_id = request()->post('thread_id');
        empty($thread_id) && $this->error('不存在的帖子');

        //
        $data['member_id'] = MID;
        $data['thread_id'] = $thread_id;
        $data['create_time'] = time();

        $insert_id = db('member_wish_thread')->insertGetId($data);

        if ($insert_id) {
            return ['code' => 0, 'msg' => '', 'data' => $data];
        }
    }

    /**
     * @title 移除收藏
     */
    public function wish_remove() {

        $thread_id = request()->post('thread_id');
        $member_id = MID;
        empty($thread_id || $member_id) && $this->error('不存在的帖子');


        $affect_rows = db('member_wish_thread')->where('member_id', $member_id)->where('thread_id', $thread_id)->delete();

        if ($affect_rows) {
            return ['code' => 0, 'msg' => 'success', 'data' => $affect_rows];
        }
    }

    /**
     * @title 发贴管理  
     */
    public function thread() {
        // 我发布的帖子
        $lists = model('thread')->where('member_id', MID)->order('top desc,recommend desc, id desc')->paginate(100, false, ['query' => request()->get()]);
        $count = model('thread')->where('member_id', MID)->count();

        $this->assign('pager', $lists->render());
        $this->assign('lists', $lists);
        $this->assign('count', $count);

        // 我收藏的帖子
        $wheres = [
                ['a.member_id', '=', MID]
        ];
        $lists2 = model('member_wish_thread')->model_where($wheres)->order('a.id desc')->paginate(100, false, ['query' => request()->get()]);
        $count2 = model('member_wish_thread')->model_where($wheres)->count();

        $this->assign('pager2', $lists2->render());
        $this->assign('lists2', $lists2);
        $this->assign('count2', $count2);



        return view();
    }

    /**
     * @title 获取帖子回复内容
     */
    public function thread_comment_read() {

        $thread_comment_id = request()->post('thread_comment_id');
        $data['content'] = db('thread_comment')->where('id', $thread_comment_id)->value('content');
        return ['code' => 0, 'msg' => 'success', 'data' => $data];
    }

    /**
     * @title 更新帖子回复的内容
     */
    public function thread_comment_update() {

        $thread_comment_id = request()->post('thread_comment_id');
        $content = request()->post('content');
        $affect_row = db('thread_comment')->where('id', $thread_comment_id)->setField('content', $content);
        return ['code' => 0, 'msg' => 'success', 'data' => $affect_row];
    }

    /**
     * @title 回复删除
     */
    public function thread_comment_delete() {
        $thread_comment_id = request()->post('thread_comment_id');
        $affect_row = db('thread_comment')->where('id', $thread_comment_id)->delete();
        return ['code' => 0, 'msg' => 'success', 'data' => $affect_row];
    }

    /**
     * @title 回复赞
     */
    public function thread_comment_zan() {
        $thread_comment_id = request()->post('thread_comment_id');
        $member_id = MID;
        $ok = request()->post('ok');

        //
        $msg = model('thread_comment')->thread_comment_zan($thread_comment_id, $member_id, $ok);
        if (empty($msg)) {
            return ['code' => 0, 'msg' => 'success', 'data' => 'ok'];
        } else {
            return ['code' => 1, 'msg' => '操作失败', 'data' => 'error'];
        }
    }

    /**
     * @title 我的消息 
     */
    public function message() {
        return view();
    }

    // 重置密码
    public function password_reset() {
        if (request()->isPost()) {


            $post = request()->post();

            //
            $msg = model('member')->password_reset($post, MID);
            if (is_number($msg)) {
                $this->success('更新成功');
            } else {
                $this->error('更新失败');
            }
        }
    }

}
