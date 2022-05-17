<?php

namespace app\index\controller;

use app\common\controller\Base;

class Order extends Base {

    public function index()
    {

        if ( !$member = member_is_login() ) {
            $this->error('请先登录～', 'user/login');
        }
        $member_id = $member['id'];

        // 获取商品信息
        $goodId = input('param.id');
        if ( !$goodId ) {
            $this->error('请求异常，请重试～');
        }
        $goodInfo = model('goods')->where('id', '=', $goodId)->find();
        if ( !$goodInfo ) {
            $this->error('请求异常，请重试～');
        }

        //生成订单号
        $uuid = uniqid(date('YmdHis'));
        // 额外参数回调验证
        $orderHash = md5($member_id . time());

        // 生成订单信息
        $inserts = [
            'user_id' => $member_id,
            'order_number' => $uuid,
            'order_hash' => $orderHash,
            'goods_id' => $goodId,
            'article_id' => input('param.article_id') ?: 0,
            'create_time' => time()
        ];
        model('order')->insert($inserts);

        $params = [
            'out_trade_no' => $uuid,
            'total_amount' => $goodInfo['price'],
            'subject' => $goodInfo['name'],
            'body' => [
                'order_hash' => $orderHash
            ],
        ];

        $result = controller('common/AliPay')->pay($params);
        if ( !empty($result['code']) && $result['code'] == 10000 ) {
            $expireTime = time() + 300;
            $data       = [
                'qr_code' => $result['qr_code'],
                'order_number' => $uuid,
                'good_info' => $goodInfo,
                'expire_date' => date('Y-m-d H:i:s', $expireTime),
                'expire_time' => $expireTime

            ];
            $this->assign($data);
            return view();
        } else {
            $this->redirect('/');
        }

    }

    public function pay_order_callback() {
        $callback = input('post.');
        if (!$callback) exit();

        $fields = ['out_trade_no', 'buyer_logon_id', 'receipt_amount', 'trade_status', 'trade_no', 'body'];
        foreach ($fields as $field) {
            if (empty($callback[$field])) exit;
        }

        // hash 缺失异常
        if (empty($callback['body']['order_hash']))exit;
        $orderHash = $callback['body']['order_hash'];

        // 获取订单信息
        $where = [
            ['order_number', '=', $callback['out_trade_no']],
            ['order_hash', '=', $orderHash],
        ];
        $orderInfo = model('order')->where($where)->find();

        $tradeStatus = [
            "WAIT_BUYER_PAY" => 0,#交易创建，等待买家付款
            "TRADE_CLOSED" => 1,#未付款交易超时关闭，或支付完成后全额退款
            "TRADE_SUCCESS" => 2,#交易支付成功
            "TRADE_FINISHED" => 3,
        ];

        // 更新订单
        $update = [
            'buyer_logon_id' => $callback['buyer_logon_id'],
            'receipt_amount' => $callback['receipt_amount'],
            'trade_status' => $callback['trade_status'],
            'trade_no' => $callback['trade_no'],
            'trade_status' => $tradeStatus[$callback['trade_status']]?:0,
            'update_time' => time(),
        ];
        model('order')->where($where)->save($update);

        // 支付成功处理
        if ($callback['trade_status'] == 'TRADE_SUCCESS') {
            $goodsId = $orderInfo['goods_id'];
            $goodsInfo = model('goods')->where('id', '=', $goodsId)->find();
            $userId = $orderInfo['user_id'];
            if($goodsId == 1) {
                redis()->set("user_preview:{$userId}:{$orderInfo[article_id]}",1, 86400);
            } else {
                if ($userInfo = model()->where('id', '=', $userId)->find()) {
                    // 计算有效期
                    if (!empty($userInfo['level_expire']) && $userInfo['level_expire'] >= time()) {
                        $update['level_expire'] = $userInfo['expire_time'] + $goodsInfo['add_expire_day'] * 86400;
                    } else {
                        $update['level_expire'] = time() + $goodsInfo['add_expire_day'] * 86400;
                    }
                    $update['user_level'] = $goodsId;

                    model('member')->where('id', '=', $userId)->save();
                }
            }
        }

        return "success";
    }
}
