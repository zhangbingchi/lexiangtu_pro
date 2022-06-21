{extend name="base:base" /}
{block name="head"}
    <link rel="stylesheet" href="__PUBLIC__/static/phpfly/css/vip_center.css">
{/block}
{block name="body"}
<div class="layui-container">
    <div class="layui-row layui-col-space1" style="padding-top: 30px">
        <div class="layui-col-md3" style="padding: 10px">
            <div class="pricing-wco-seven bg-blue">
                <div class="pricing-title">
                    <div class="name">月费会员</div>
                    <div class="pricing-price">
                        <span class="pricing-price-unit">￥</span>18
                        <span class="pricing-price-time">/ 月</span>
                    </div>
                    <div class="pricing-flow">免费在线预览所有图集</div>
                    <div class="pricing-flow">原版图集：支持下载</div>
                    <div class="pricing-flow">打包下载：否</div>
                    <div class="pricing-flow">精彩视频：无权限</div>
                    <div class="pricing-flow">私人定制：否</div>
                    <div class="pricing-flow">每日可下载数：5 个</div>
                </div>
                <?php if($user_level < 2) { ?>
                    <a target="_self" href="/order/purchase/2">
                        <div class="pricing-btn pricing-btn-4 btn-effects4">选择升级</div>
                    </a>
                <?php } else { ?>
                    <div class="pricing-btn pricing-btn-4 btn-effects4 layui-btn-disabled">选择升级</div>
                <?php } ?>
            </div>
        </div>
        <div class="layui-col-md3"  style="padding: 10px">
            <div class="pricing-wco-senior">
                <div class="pricing-title">
                    <div class="name">年费会员</div>
                    <div class="pricing-price">
                        <span class="pricing-price-unit">￥</span>88
                        <span class="pricing-price-time">/ 年</span>
                    </div>
                    <div class="pricing-flow">免费在线预览所有图集</div>
                    <div class="pricing-flow">原版图集：支持下载</div>
                    <div class="pricing-flow">打包下载：否</div>
                    <div class="pricing-flow">视频写真：支持下载</div>
                    <div class="pricing-flow">私人定制：否</div>
                    <div class="pricing-flow">每日可下载数：20 个</div>
                </div>
                <?php if($user_level < 3) { ?>
                    <a target="_self" href="/order/purchase/3">
                        <div class="pricing-btn pricing-btn-4 btn-effects4">选择升级</div>
                    </a>
                <?php } else { ?>
                    <div class="pricing-btn pricing-btn-4 btn-effects4 layui-btn-disabled">选择升级</div>
                <?php } ?>
            </div>
        </div>
        <div class="layui-col-md3"  style="padding: 10px">
            <div class="pricing-private">
                <div class="pricing-title">
                    <div class="name">永久会员</div>
                    <div class="pricing-price">
                        <span class="pricing-price-unit">￥</span>188
                        <span class="pricing-price-time">&nbsp; / 永久</span>
                    </div>
                    <div class="pricing-flow">免费在线预览所有图集</div>
                    <div class="pricing-flow">原版图集下载：支持下载</div>
                    <div class="pricing-flow">打包下载：否</div>
                    <div class="pricing-flow">视频写真：支持下载</div>
                    <div class="pricing-flow">私人定制：否</div>
                    <div class="pricing-flow">每日可下载数：30 个</div>
                </div>
                <?php if($user_level < 4) { ?>
                    <a target="_self" href="/order/purchase/4">
                        <div class="pricing-btn pricing-btn-4 btn-effects4">选择升级</div>
                    </a>
                <?php } else { ?>
                    <div class="pricing-btn pricing-btn-4 btn-effects4 layui-btn-disabled">选择升级</div>
                <?php } ?>
            </div>
        </div>
        <div class="layui-col-md3"  style="padding: 10px">
            <div class="pricing-private">
                <div class="pricing-title">
                    <div class="name">钻石会员</div>
                    <div class="pricing-price">
                        <span class="pricing-price-unit">￥</span>288
                    </div>
                    <div class="pricing-flow">免费在线预览所有图集</div>
                    <div class="pricing-flow">原版图集下载：支持下载</div>
                    <div class="pricing-flow">打包下载：支持下载</div>
                    <div class="pricing-flow">视频写真：支持下载</div>
                    <div class="pricing-flow">私人定制：支持</div>
                    <div class="pricing-flow">每日可下载数：50 个</div>
                </div>
                <?php if($user_level < 5) { ?>
                    <a target="_self" href="/order/purchase/5">
                        <div class="pricing-btn pricing-btn-4 btn-effects4">选择升级</div>
                    </a>
                <?php } else { ?>
                    <div class="pricing-btn pricing-btn-4 btn-effects4 layui-btn-disabled">选择升级</div>
                <?php } ?>
            </div>

        </div>
    </div>
    <div style="margin-top: 30px;">
        <div class="page-content">
            <h4 style="padding-top:15px;border-bottom: 1px solid #eaeaea;padding: 10px 0;">
                <span>会员权限说明：</span>
            </h4>
            <br>
        </div>
        <div style=" padding-bottom: 10px; " class="sm">
            <p>1、为了避免用户恶意下载，月度会员每天最多可以下载5个资源 、年费赞助20个资源、永久赞助30个资源、钻石会员50个资源！</p>
            <p style=" color: #E62129;">
                2、<span style="font-weight:800">禁止网站用户以任何形式将写真资源发布出去，违者将永久封禁用户账号！</span>
            </p>
            <p>3、下载文件若出现任何问题可以直接在留言区反馈</p>
            <p>4、下载文件为压缩包，请留意文章中的解压密码</p>
            <p style=" color: #E62129;">5、<span style="font-weight:800">请勿在百度云网盘在线解压，谢谢支持！</span></p>
        </div>
    </div>
</div>
{/block}
{block name="foot_js"}
<script>
    layui.use(['carousel', 'element'], function(){
        var carousel = layui.carousel;
        var element = layui.element;
        //建造实例
        carousel.render({
            elem: '#vip_cneter'
            ,width: '100%' //设置容器宽度
            ,arrow: 'always' //始终显示箭头
            //,anim: 'updown' //切换动画方式
        });
    });
</script>
{/block}