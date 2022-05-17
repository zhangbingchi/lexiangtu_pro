<?php

namespace app\common\controller;

require_once VENDOR_PATH . 'alipay/AopClient.php';
require_once VENDOR_PATH . 'alipay/AopCertification.php';
require_once VENDOR_PATH . 'alipay/request/AlipayTradePrecreateRequest.php';

class Alipay {

    public function pay($params) {

        $aliConfig = config('alipay.');
        $aop = new \AopClient();

        $aop->gatewayUrl = $aliConfig['gatewayUrl'];
        $aop->appId = $aliConfig['app_id'];
        $aop->rsaPrivateKey = $aliConfig['merchant_private_key'];
        $aop->alipayrsaPublicKey = $aliConfig['alipay_public_key'];
        $aop->signType = $aliConfig['sign_type'];
        $aop->postCharset = $aliConfig['charset'];
        $aop->format = 'json';
        $aop->apiVersion = '1.0';

        $params['product_code'] = 'FACE_TO_FACE_PAYMENT';
        $json = json_encode($params);

        $request = new \AlipayTradePrecreateRequest();
        $request->setNotifyUrl($aliConfig['notify_url']);
        $request->setBizContent($json);
        $result = $aop->execute ( $request);

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        return json_decode(json_encode($result->$responseNode), true);
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
