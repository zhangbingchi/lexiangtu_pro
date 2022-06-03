<?php

return [
    //应用ID,您的APPID。
    'app_id' => "2021001159685803",

    //异步通知地址
    'notify_url' => "http://show.lexiangtu.top/order/order_pay_callback",

    //同步跳转
    'return_url' => "http://show.lexiangtu.top/order/return_notify",

    // 标题
    'subject' => '乐享图-订单支付',

    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type' => "RSA2",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

    //商户私钥
    'merchant_private_key' => "MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCCGpGifig5L+hhqOnzf+ip7uF0excnGiOP2n5QXd9kB6qHJFOypZnuQhOKLX6llsxVgJljz8dyDl3L2fb9UG9bmYHGzmoYTAZTR2+GxX8/VXgJi/MhkjgQ1ZfpGtIwDoY36qQlffxBbdazKQsTyQeMGOXcRmLOjhdlGNQQQy9ifDD0c3B5oCReozrOZyw+SK1/yml/SbeNbhxTUQi2omrhSYjql+u2eB49MEHDL2w9D91gTm1BnI8oT5mCBD+cn7LPPV6N5iZP2nrbMMkCbFfigq4PzoczjgLuioKWEv9OIA+56JebtQ+Z7yxBVUo9Pqo+uV7M+LfuuB+DwBFPgUfdAgMBAAECggEAAzZItixLLe5C3HZhIEPeKKPfKRMI5Uw96IVKbQ2EQGH4EdIRxu1TuZAkD1tELy5j6RB9uPseP3CfXDMLaAGeXjKSA6iA8gyec1vmIvupQpUHm6S64e9MNw4u6/BflBQnuCWw28QagDsH+/Bdd6WU7B6JPkD2m4biiPpt8eDWwKWrPRnyllDtQDKThLUv+5aoDknyta5jMClKzbBDryikhhvoOAo/ryu8sDWIxI/an+1AWdTqOf5AX4s9m3tWEYxMG9Su8FSjW9GdYuAT07stJxYUvhlNqMUHulsRRZJMwqcLh1MOZWtlHOWJsxQxeWfxrqI1IlnGpM9K2RuXLRviAQKBgQDGDI+XqXQyII0aBNyJOUaaSDx/8K8yhj/XBGHCk0WjKLN5gbbKnBLxkeiue2sh44Qsa9XOqyQG8LQMQoyrVK6sY6rCIyDUn2qxu9PLaI0ya5jH2Qp9wqQFAMmGlPVolN0sRE0nLEBUtRNxWa9i8yxUY7uXyWqqSTv+AcJnszqTHQKBgQCoLF6syUlxlwiQ65r7gACMlJZMWFGZ04ZnpSdiE30bdW7FDfy0BesNCJgc6qKPXk/XEqYteZliRtubX5g+YsfxMs3630mj5C3Gg3FyttNMWFcZId+a/e/s8CjV7jJr2oSt7C3+whRysxMDRaXQ4rARGLbuewZ1qZvUO6v54CSrwQKBgQCtFntEpE+uI67OJ6OKtqkS28EsW/DyakxPIkBCaq342/CHaCuWRfN0dv3xyGGoO4zfudsiBYa2HhZthJgmgRssBOtPQp5F1ZHNBggjhRuqDkl3mCPIJ51r1fVLDtKwdTIbpxH7A3yxy5PTg/t5smdy1bs0/E6hxuGMrIL4WLb/rQKBgHl30soqeQm6dU13X3HYeo0PpZ9vC0F4LtQdzdxhBzQWFfPurl+5BpVbZ8M7Fj9Hd5N4vN6LveXmGCiZW3V0E8Z7U5uoO6BM52NC/WZF90hlZkOY29EvKWSR8mzSp0iPhNW6iV5BAFP4U/tBCwtdMJ6ooziNU5UY9JzOnODWrKYBAoGAVtxjYSVyh6pjvGXwWHn5+eKONTxHbGuwcvqmAJASPRs+VAGbt6UIpwI6q8T5EExIBF+Ky2XbRf3UE3f2zM3W/E5mFHZ0xVfz1vZxVlRrl/4gIUAA15KLjZG6rxFQqZ8cWvo9Xu4ldTjK1XgYoDqCt1zwssuE1Ga+cKYgZuqQtaM=",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAoEKxxC/BB8fALJf0TbkgM6Wjnpg7UjDtuvRZVHs7sXNJzfdhetJOU3AddX28R+tFCmygIi88b6EopTI6PemIc6tJ7r+xGJzCXVZNCUG5Lnmp/UZe4tnpKOTHWxtNF/A1V5srlWUjIMotgxVvgqn2w/AxfGBmjlIHnuhV/eJ+/sZjAWxl5ax1zMWzBou46yjDCqFUbk4JQ5TKangM/vvtwNyeQXKIseEIwQvDmkmrUfuhUNu20U7+CFjOGggeQCRuDhaekbCkNjp2bcoaJOq/D+gdhmdPLyLiKPVFYKGCvxJe58ouqnChP30Nsiu5mBjHrTNkiu4TOVoUhbAQH9hBwQIDAQAB",

];