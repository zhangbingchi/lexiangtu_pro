<?php

namespace app\index\controller;

use app\common\controller\Base;
use think\Request;
use think\response\Json;
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

        // 综合15条帖子
        $lists_thread20 = model('thread')->model_where([['a.is_delete', '=', 0]])->limit(15)->select();
        $this->assign('lists_thread20', $lists_thread20);

        // 加载签到的初始化状态
        $member = member_is_login();
        $member_id = !empty($member) ? $member['id'] : 0;
        if ($member_id) {
            $member = model('member')->get($member_id);
        }
        $this->assign('user_level',  !empty($member['user_level'])?$member['user_level']:0);


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

    // 菜单栏目
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
        $k_id = input('param.k_id')?:0;
        $page = input('param.page', 1);

        $wheres = [['a.is_delete', '=', 0]];
        $orderBy = 'a.top desc,a.id desc';
        switch ($alias) {
            // 精华
            case 'wonderful':
                $wheres[] = ['a.status', '=', 1];
                break;
            // 标签筛选
            case 'tags':
                if ($k_id) {
                    $wheres['thread_tags'] = ['t.tags_id', '=', $k_id];
                }
                break;
            case 'shipin':
                $wheres[] = ['a.source_type', '=', 1];
            case 'recommend':
                $orderBy = 'a.weight DESC, a.id DESC';
        }

        $lists = model('thread')->model_where($wheres, $orderBy)->paginate(15, false, ['query' => request()->get()]);
        $this->assign('lists', $lists);

        $count = model('thread')->model_where($wheres)->count();
        $pager = new Page();
        $url = url("/thread/{$alias}/{$k_id}/page/{page}");

        $pager->setUrl($url);
        $pager->setTotal($count);
        $pager->setLimit(15);
        $pager->setPage($page);

        $this->assign('count', $count);
        $this->assign('pager', $pager->render());

        if ($member =  member_is_login() ) {
            $member = model('member')->get($member['id']);
        }
        $this->assign('user_level',  !empty($member['user_level'])?$member['user_level']:0);

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
        $this->assign('user_level',  !empty($member['user_level'])?$member['user_level']:0);
        $this->assign('user_points',  !empty($member['points'])?$member['points']:0);

        // 文章详情
        $key = "lexiangtu_article_ingredients:{$articleId}";
        if (!$ingredients = unserialize( redis()->get($key) ) ) {
            $ingredients = model('thread_ingredients')->where('article_id', '=', $one['article_id'])->select();
            redis()->set($key, serialize($ingredients), 86400);
        }
        $this->assign('thread_ingredients', $ingredients);

        // 文章标签
        $key = "lexiangtu_article_tags:{$articleId}";
        if (!$tags = unserialize( redis()->get($key) ) ){
            $tags = model('thread_tags')->alias('tt')->field('title')
                ->leftJoin('tags t', 'tt.tags_id=t.id')
                ->where('article_id', '=', $one['id'])
                ->select()->toArray();
            $tags = array_column($tags, 'title');
            redis()->set($key, serialize($tags), 86400);
        }
        $this->assign('thread_tags', $tags);

        // 图片列表
        $key = "lexiangtu_article_images:{$articleId}";
        if (!$threadImages = unserialize( redis()->get($key) ) ) {
            $threadImages = model('thread_images')->where('article_id', '=', $one['article_id'])->limit(20)->select();
            redis()->set($key, serialize($threadImages), 86400);
        }
        $this->assign('thread_images', $threadImages);

        // 下载权限
        $levelAuth['member_id'] = $member_id;
        $levelAuth['is_down_auth'] = 0;
        $levelAuth['user_level'] = '未注册';
        // 微博网红默认只能产看3张
        $levelAuth['is_view_auth'] = $one['source_type'] == 2 ? 0 : 1;
        $allowCount = 0;
        if ($member_id) {
            $allowCount = floor($member['points'] / 50);

            $levelAuth['is_down_auth'] = !!(redis()->get("user_preview:{$member_id}:{$articleId}"));

            // 用户等级
            $levelAuth['user_level'] = '普通会员';
            if ($member['user_level'] >= 2) {
                $goods_info = model('goods')->where('id', '=', $member['user_level'])->find();
                $levelAuth['user_level'] = $goods_info['name'];
            }
            // 微博网红年度可预览、永久可下载
            if ($one['source_type'] == 2) {
                if ($member['user_level'] >= 3 ) {
                    $levelAuth['is_view_auth'] = 1;
                }
            }

            // 检查会员权限
            if (!$levelAuth['is_down_auth']) {
                // 检查用户当日是否下载过这个文件
                $key = "user_download:{$member_id}:" . date('Ymd');
                if (!redis()->hExists($key,$articleId)) {
                    if ($one['source_type'] == 1) {
                        // 视频钻石会员下载
                        if ($member['user_level'] == 5) {
                            $levelAuth['is_down_auth'] = 1;
                        }
                    } else if ($one['source_type'] == 2) {
                        // 微博网红永久会员下载
                        if ($member['user_level'] >= 4) {
                            $levelAuth['is_down_auth'] = 1;
                        }
                    } else {
                        // 积分足够可下载
                        if($member['points'] >= 50) {
                            $levelAuth['is_down_auth'] = 1;
                        }
                    }

                } else {
                    $levelAuth['is_down_auth'] = 1;
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
                $value['display_comment_edit'] = ($member_id == 1 || $member_id == $value['member_id']) ? 1 : 0;
                $value['display_comment_del'] = ($member_id == 1 || $member_id == $value['member_id']) ? 1 : 0;
                $value['display_comment_accept'] = ($member_id == 1) ? 1 : 0;
            }
        }
        $this->assign('lists_comment', $lists_comment);

        // 浏览数权重增加
        model('thread')->where('article_id', $articleId)->setInc('hits');
        model('thread')->where('article_id', $articleId)->setInc('weight', 100);

        return view();
    }

    // 资源下载
    public function thread_down() {
        $params = input('param.');
        if (empty($params['id'])) {
            return $this->redirect('/');
        }
        $article_id = $params['id'];

        // 用户信息
        if (!$member = member_is_login()) {
            $this->redirect('user/login');
        }
        $member_id = $member['id'];
        $member_info = model('member')->where('id', '=', $member_id)->find();
        // 用户等级
        $user_level = '普通会员';
        if ($member_info['user_level'] >= 2) {
            $goods_info = model('goods')->where('id', '=', $member_info['user_level'])->find();
            $user_level = $goods_info['name'];
        }

        // 预览权限
        $is_down_auth = redis()->get("user_preview:{$member_id}:{$article_id}") ? 1 : 0;
        // 检查会员权限
        if (!$is_down_auth) {
            // 检查用户当日是否下载过这个文件
            $key = "user_download:{$member_id}:" . date('Ymd');
            if (!redis()->hExists($key,$article_id)) {
                $thread = model('thread')->where('article_id', $article_id)->find();
                if(!$thread) {
                    return $this->redirect('/');
                } else {
                    if ($thread['source_type'] == 1) {
                        // 视频类
                        if ($member_info['user_level'] == 5) {
                            $is_down_auth = 1;
                        }
                    } else if ($thread['source_type'] == 2) {
                        // 微博网红
                        if ($member_info['user_level'] >= 4) {
                            $is_down_auth = 1;
                        }
                    } else {
                        $is_down_auth = 1;
                    }
                    // 判断当前用户积分是否足够
                    if($is_down_auth && $member_info['points'] >= 50) {
                        redis()->hSet($key, $article_id, time());
                        redis()->expire($key, 86400);
                        // 扣除积分
                        model('member')->where('id', $member_id)->setInc('points', -50);
                    }
                }
            } else {
                $is_down_auth = 1;
            }
        }

        if ($is_down_auth) {
            $thread = model('thread')->where('article_id', '=', $article_id)->find();
            $data = [
                'article_name' => $thread['title'],
                'article_id' => $thread['article_id'],
                'baidu_url' => $thread['baidu_url'],
                'baidu_code' => $thread['baidu_code'],
                'unzip_password' => $thread['unzip_password'],
                'is_down_auth' => $is_down_auth,
                'user_level' => $user_level
            ];

            // 浏览数权重增加
            model('thread')->where('article_id', $article_id)->setInc('down_count');
            model('thread')->where('article_id', $article_id)->setInc('weight', 100);

            $this->assign($data);

            return view();

        } else {
            $this->success('当前积分、权限不足，可升级会员获取更多积分～', '/vip_center');
        }
    }

    /**
     * @title 帖子评论的添加 
     * 前置条件：登录后
     */
    public function thread_comment_add() {

        if (is_array($member = member_is_login())) {
            $post = request()->post();
            if (empty($post['thread_id'])) {
                $this->error('找不到帖子');
            }
            $id = $post['thread_id'];
            $wheres = [['a.id', '=', $id],['a.is_delete', '=', 0]];
            $one = model('thread')->model_where($wheres)->find();
            //  微博网红无评论
            if ($one['source_type'] != 0){
                return json([], 200);
            }

            $msg = model('thread_comment')->thread_comment_add($post);
            if (is_numeric($msg) || empty($msg)) {
                $articleId = $one['article_id'];
                $memberId = $member['id'];
                // 增加权重
                model('thread')->where('id', $id)->setInc('weight', 200);

                //判断是否是7日内注册回复
                $memberInfo = model('member')->where('id', $memberId)->find()->toArray();
                if ($memberInfo['create_time'] + 7 *86400  >= time()) {
                    // 可免费下载一次
                    $key = "new_user_reply_free_download:" . date('Ymd');
                    if(!redis()->sIsMember($key, $memberId)) {
                        redis()->sAdd($key,$memberId);
                        // 设置文章可下载
                        redis()->set("user_preview:{$memberId}:{$articleId}",1, 86400);
                    }
                }
                // 发布成功 ，跳转到所属的帖子
                $this->success('发布成功', url('/thread_views/' . $articleId));
            } else {
                $this->error($msg);
            }
        } else {
            $this->error('请登录后进行操作');
        }
    }

    // 点赞
    public function thread_zan() {
        if($member = member_is_login()) {
            $post = request()->post();
            if (empty($post['thread_id']) || !isset($post['zan']) ) {
                return ['code' => 1, 'message' => '请求异常～'];
            }
            $where = [
                ['member_id', '=', $member['id']],
                ['thread_id', '=', $post['thread_id']],
            ];
            if (!empty($post['zan'])) {
                if (!$record = model('thread_hits_zan')->where($where)->find()) {
                    $data = $where;
                    $data['create_time'] = time();
                    model('thread_hits_zan')->insert($data);
                    // 文章点赞数+1
                    model('thread')->where('id', $post['thread_id'])->setInc('like');
                }
            } else {
                model('thread_hits_zan')->where($where)->delete();
            }

            return ['code' => 0, '点赞成功！'];

        } else {
            return ['code' => 1, 'message' => '请先登录～'];
        }
    }

    public function thread_wish() {
        if($member = member_is_login()) {
            $post = request()->post();
            if (empty($post['thread_id']) || !isset($post['wish']) ) {
                return ['code' => 1, 'message' => '请求异常～'];
            }
            $where = [
                ['member_id', '=', $member['id']],
                ['thread_id', '=', $post['thread_id']],
            ];
            if (!empty($post['wish'])) {
                if (!$record = model('thread_hits_wish')->where($where)->find()) {
                    $data = $where;
                    $data['create_time'] = time();
                    model('thread_hits_wish')->insert($data);
                    // 文章收藏数+1
                    model('thread')->where('id', $post['thread_id'])->setInc('fav');
                }
            } else {
                model('thread_hits_zan')->where($where)->delete();
            }

            return ['code' => 0, '点赞成功！'];

        } else {
            return ['code' => 1, 'message' => '请先登录～'];
        }
    }

    public function echoHtml() {

        $content = '';
        $lists = model('thread')->where('is_delete',0)->order('id', 'desc')->limit(22)->select();
        foreach ($lists as $article) {
            $articleId = $article['article_id'];
            $title = $article['title'];

            $content .= "{$title}[5P]--原版5400*3600图集" . PHP_EOL . PHP_EOL;
            $content .= "[size=5][color=Red]{$title}[/color][/size]" . PHP_EOL . PHP_EOL. PHP_EOL;

            // 文章详情
            $ingredients = model('thread_ingredients')->where('article_id', $articleId)->select();
            foreach ($ingredients as $item) {
                $content .= $item['name'] . '    ' . $item['dosage'] . PHP_EOL;
            }
            $content .= PHP_EOL . PHP_EOL;

            $content .= "[size=5]原版图集下载链接：[url=http://show.lexiangtu.top/thread_views/{$articleId}.html?is_recommend=1][color=Blue]http://show.lexiangtu.top/thread_views/{$articleId}.html[/color][/url][/size]";

            $content .= PHP_EOL . PHP_EOL . PHP_EOL;

            $content .= '预览图：' . PHP_EOL . PHP_EOL;

            $threadImages = model('thread_images')->where('article_id', $articleId)->limit(20)->select();
            foreach ($threadImages as $item) {
                $content .= "[img]http://static.lexiangtu.top/media/images/{$item['image']}[/img] " . PHP_EOL;
            }

            $content .= PHP_EOL . PHP_EOL . PHP_EOL;


            $content .= "标签：" . str_replace(',', ' ',$article['ingredient_list']);

            $content .= PHP_EOL . PHP_EOL . PHP_EOL;
        }


        file_put_contents('recommend.log', $content);
    }


    public function baiduRename()
    {
        //[{"path":"/解密图集/摄影专栏/秀人网/XR.2901-3000/朱可儿FlowerNo.2953.zip","newname":"朱可儿FlowerNo.2953.zip_001"}]

        $rename = [];
        $where  = [
            ['id', '>=', 8265],
            ['id', '<=', 8311],
        ];
        $lists  = model('thread')->where($where)->order('id', 'desc')->limit(20)->select();
        foreach ($lists as $item) {
            $rename[] = [
                "path" => "/解密图集/摄影专栏/模范学院/MF.001-450/{$item['cover_number']}.zip",
                "newname" => "{$item['cover_number']}.zip_001"
            ];
        }

        echo json_encode($rename);
        die;

    }
}
