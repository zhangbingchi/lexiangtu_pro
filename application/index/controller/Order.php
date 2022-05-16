<?php

namespace app\index\controller;

use app\common\controller\Base;

require_once VENDOR_PATH . 'alipay/AopClient.php';
require_once VENDOR_PATH . 'alipay/AopCertification.php';
require_once VENDOR_PATH . 'alipay/request/AlipayTradeQueryRequest.php';
require_once VENDOR_PATH . 'alipay/request/AlipayTradeWapPayRequest.php';
require_once VENDOR_PATH . 'alipay/request/AlipayTradeAppPayRequest.php';

class Order extends Base {
    public function index()
    {
        $aliConfig = config('alipay.');
        //1、execute 使用
        $aop = new \AopClient();

        $aop->gatewayUrl = $aliConfig['gatewayUrl'];
        $aop->appId = $aliConfig['app_id'];
        $aop->rsaPrivateKey = $aliConfig['merchant_private_key'];
        $aop->alipayrsaPublicKey = $aliConfig['alipay_public_key'];
        $aop->signType = $aliConfig['sign_type'];
        $aop->postCharset = $aliConfig['charset'];
        $aop->format = 'json';
        $aop->apiVersion = '1.0';

        $request = new \AlipayTradeQueryRequest ();
        $params = [
            'out_trade_no' => '20150320010343101001',
            'total_amount' => '10.00',
            'subject' => '测试',
            'product_code' => 'FACE_TO_FACE_PAYMENT'
        ];
        $request->setBizContent(json_encode($params));
        $result = $aop->execute($request);
        var_dump($result);
    }

    public function notify()
    {
        $post = input();
        if ($post['trade_status'] == "TRADE_SUCCESS") {
            Db::name('order')->where('out_trade_no',$post['out_trade_no'])->update(array('pay_status'=>'success'));
            //操作数据库 修改状态
            echo "SUCCESS";
        }

    }
}
