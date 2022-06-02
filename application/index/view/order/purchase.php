{extend name="base:base" /}
{block name="head"}
<link href="__PUBLIC__/static/phpfly/css/pay.css" rel="stylesheet" media="screen">
{/block}

{block name="body"}
<div class="layui-container" style="width: 100%">
    <h1 class="mod-title">
        乐享图——开通<?php echo $good_info['name']; ?>
    </h1>
    <div class="mod-ct">
        <div class="order"></div>
        <div class="amount" id="money">¥ <?php echo $good_info['price']; ?></div>

        <div class="qrcode-img-wrapper" data-role="qrPayImgWrapper">
            <div data-role="qrPayImg" class="qrcode-img-area">
                <div class="ui-loading qrcode-loading" data-role="qrPayImgLoading" ></div>
                <div style="position: relative;display: inline-block;">
                    <img  id="show_qrcode" width="300" height="300" src="<?php echo $qr_code_url; ?>"  title="本二维码仅可支付一次,请勿重复使用,本二维码仅可支付一次,请勿重复使用,本二维码仅可支付一次,请勿重复使用,本二维码仅可支付一次,请勿重复使用"  style="display: block;">
                    <img onclick="$('#use').hide()" id="use" src="__PUBLIC__/static/phpfly/images/pay/logo_alipay.png"
                         style="position: absolute;top: 50%;left: 50%;width:32px;height:32px;margin-left: -16px;margin-top: -30px">
                </div>
            </div>
        </div>

        <div class="time-item" style = "padding-top: 10px">
            <!--其他手机浏览器+支付宝支付-->
            <div class="time-item" id="msg"><h1><h1>支付完成后，请返回此页</h1></div>
            <div class="time-item"><h1>订单:<?php echo $order_number; ?></h1> </div>
            <strong id="hour_show">0时</strong>
            <strong id="minute_show">0分</strong>
            <strong id="second_show">0秒</strong>
        </div>

        <div class="tip">
            <div class="ico-scan"></div>
            <div class="tip-text">
                <p id="showtext">打开支付宝 [扫一扫]</p>
            </div>
            <div class="ico-scan"></div>
        </div>

        <div class="tip-text">
            <?php echo $good_info['describe'];?>
            <?php echo ""; ?>
        </div>

    </div>
    <div class="foot">
        <div class="inner" style="display:none;">
            <p>手机用户可保存上方二维码到手机中</p>
            <p>在微信扫一扫中选择“相册”即可</p>
            <p></p>
        </div>
    </div>
</div>
{/block}

{block name="foot_js"}
<script type="text/javascript">

    var myTimer;
    var strcode = '二维码过期啦，请重新下单~~~';
    var outTime="270";
    var intDiff="270";
    var goTimerBegin =  new Date().getTime();
    var open_alipay_url = "<?php echo $alipay_url; ?>";

    $(document).on('visibilitychange', function (e) {
        if (e.target.visibilityState === "visible") {
            var s = Math.floor((parseInt(new Date().getTime())-parseInt(goTimerBegin))/1000);
            intDiff = outTime-s;
            $("#show_qrcode").attr("src",$("#show_qrcode").attr("src"));
        }
    });

    layui.use('layer', function(){
        var layer = layui.layer;
        $().ready(function(){
            //默认6分钟过期
            goTimer();
        });

        function goTimer() {
            myTimer = window.setInterval(function () {
                var day = 0,
                    hour = 0,
                    minute = 0,
                    second = 0;//时间默认值
                if (intDiff > 0) {
                    day = Math.floor(intDiff / (60 * 60 * 24));
                    hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                    minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                    second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
                }
                if (minute <= 9) minute = '0' + minute;
                if (second <= 9) second = '0' + second;
                $('#hour_show').html('<s id="h"></s>' + hour + '时');
                $('#minute_show').html('<s></s>' + minute + '分');
                $('#second_show').html('<s></s>' + second + '秒');
                if (hour <= 0 && minute <= 0 && second <= 0) {
                    qrcode_timeout();
                    clearInterval(myTimer);
                }
                intDiff = intDiff-2;

                if (strcode != ""){
                    checkdata();
                }

            }, 5000);
        }

        function checkdata(){ //定时确认是否支付成功
            $.ajax({
                url:"/order/checkOrder?out_trade_no=<?php echo $order_number; ?>",
                type:"GET",
                success:function(response){
                    if (response.code == 0 ){
                        window.clearInterval(myTimer);
                        layer.msg("支付成功， 即将跳转回详情，请及时使用权限哦", {time: 2000, icon:1});
                        setTimeout(function(){
                            // window.location = data.url;
                            location.replace(response.data.url)
                        }, 3000);

                    }
                }
            })
        }

    });
    function qrcode_timeout(){
        $('#show_qrcode').attr("src","__PUBLIC__/static/phpfly/images/pay/qrcode_timeout.png");
        $("#use").hide();
        $('#msg').html("<h1>请刷新本页</h1>");

    }

    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?ca69aec66f867486468c7731605b365d";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();

</script>
{/block}