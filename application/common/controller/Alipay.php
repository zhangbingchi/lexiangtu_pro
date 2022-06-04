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

    public function check_rsa_sign($params) {
        $aliConfig = config('alipay.');
        $aop = new \AopClient ();
        //编码格式
        $aop->postCharset="UTF-8";
        //支付宝公钥赋值
        $aop->alipayrsaPublicKey=$aliConfig['alipay_public_key'];
        //签名方式
        $sign_type="RSA2";

        //验签代码
        $flag = $aop->rsaCheckV1($params, null, $sign_type);

        return !!$flag;
    }
}
