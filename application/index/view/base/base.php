<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo !empty($title) ? $title :'乐享图 lexiangtu——最新最全的丽人写真视频馆'?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="keywords" content="乐享图,写真,丽人,最新,女神,杨晨晨,陆萱萱">
        <meta name="description" content="<?php echo !empty($title)  ? $title :'首页｜乐享图 lexiangtu——最新最全的丽人写真视频馆'?>">
        <link rel="stylesheet" href="__PUBLIC__/libs/layui/2.4.5/css/layui.css">
        <link rel="stylesheet" href="__THEME__/css/global.css">
        <script charset="UTF-8" id="LA_COLLECT" src="//sdk.51.la/js-sdk-pro.min.js"></script>
        <script>LA.init({id: "JjE7LFuC6v6gk2tQ",ck: "JjE7LFuC6v6gk2tQ"})</script>
        {block name="head"}{/block}
    </head>
    <body style="width: 100%;overflow-x: hidden;">
        {include file="base/header" /} 
        {block name="body"}{/block}
        {include file="base/footer" /} 
    </body>
</html>
<script src="__PUBLIC__/libs/layui/2.4.5/layui.js"></script>
<script>
<?php
$member = member_is_login();
if (is_array($member)) {
    ?>
        layui.cache.page = '';
        layui.cache.user = {
            username: '<?php echo $member['nickname'] ?>'
            , uid: <?php echo $member['id'] ?>
            , avatar: '<?php
    if ($member['avatar'])
        echo res_http($member['avatar']);
    else
        echo res_http('sex' . $member['sex'] . '.png');
    ?>'
            , points: 83
            , sex: '<?php echo $member['sex'] == 0 ? '男' : '女' ?>'
        };
<?php } else { ?>
        layui.cache.page = '';
        layui.cache.user = {
            username: '游客'
            , uid: -1
            , avatar: ''
            , points: 83
            , sex: '男'
        };
<?php } ?>
    layui.define(function (exports) {
        exports('baseUrl', function () {
            return '<?php echo APP_URL; ?>';
        });
    });
    layui.config({
        version: "3.0.0"
        , base: '__THEME__/js/' //这里实际使用时，建议改成绝对路径
    }).extend({
        fly: 'index'
    }).use(['fly']);
    layui.use(['jquery', 'layer', 'form', 'element'], function () {
        var $ = layui.$,
                layer = layui.layer,
                form = layui.form,
                element = layui.element;     
        //监听提交
        form.on('submit(myform)', function (data) {
            //loading
            var load = layer.msg('请稍候', {
                icon: 16
                , shade: 0.01
            });
            //   layedit.sync(index)
            $.ajax({
                //请求方式
                type: "POST",
                //请求的媒体类型
                contentType: "application/x-www-form-urlencoded",
                //请求地址
                url: data.form.action,
                //数据，json字符串
                data: data.field,
                //请求成功
                success: function (result) {
                    if (result.code == 0) {
                        if (result.msg) {
                            layer.msg(result.msg);
                            setTimeout(function () {
                                if (result.url) {
                                    location.href = result.url;
                                }
                                // x_admin_close()
                            }, 1500);
                        } else {
                            if (result.url) {
                                location.href = result.url;
                            }
                        }
                    } else {
                        layer.msg(result.msg);
                    }
                },
                //请求失败，包含具体的错误信息
                error: function (e) {
                    layer.msg('错误信息：' + e.status);
                    console.log(e.responseText);
                }
            });
            return false;
        });
    });
</script>
{block name="foot_js"}{/block}
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?bfca60d8579a0829469bc63e06907200";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();

// 右滑返回上一页，二次滑动关闭APP
document.addEventListener('plusready', function() {
    var first = null;
    var webview = plus.webview.currentWebview();
    plus.key.addEventListener('backbutton', function() {
        webview.canBack(function(e) {
            if (e.canBack) {
                webview.back(); //右滑返回上一页
            } else {
                //首次按键，提示‘再按一次退出应用’
                if (!first) {
                    first = new Date().getTime(); //获取第一次点击的时间戳
                    plus.nativeUI.toast("再按一次退出应用", {
                        duration: 'short'
                    }); //通过H5+ API 调用Android 上的toast 提示框
                    setTimeout(function() {
                        first = null;
                    }, 1000);
                } else {
                    // 获取第二次点击的时间戳, 两次之差 小于 1000ms 说明1s点击了两次,
                    if (new Date().getTime() - first < 1000) {
                        plus.runtime.quit(); //退出应用

                    }
                }
            }
        })
    });
});

</script>
