{extend name="base:base" /}
{block name="body"}
{include file="index/column_nav" /}
<div class="layui-container">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md8">
            <div class="fly-panel" style="margin-bottom: 0;">
                <div class="fly-panel-title fly-filter">
                    <a href="/thread/all" <?php
                       if (empty(request()->param('alisa')) || request()->param('alisa') == 'all') {
                           echo ' class="layui-this" ';
                       }
                       ?>>最新</a>
                    <span class="fly-mid"></span>
                    <a href="/thread/wonderful" <?php
                       if (request()->param('alisa') == 'wonderful') {
                           echo ' class="layui-this" ';
                       }
                       ?>>精华</a>
                    <span class="fly-mid"></span>
                    <a href="/thread/recommend" <?php
                    if (request()->param('alisa') == 'recommend') {
                        echo ' class="layui-this" ';
                    }
                    ?>>推荐</a>
                </div>

                <?php if ($count) { ?>
                    <ul class="fly-list">
                        <?php
                        foreach ($lists as $key => $value) {
                            ?>
                            <li>
                                <a href="<?php echo url('/thread_views/' . $value['article_id']) ?>" class="fly-avatar">
                                    <img style="width:75px;height:110px" src="__MEDIA_URL__<?php echo $value['image']; ?>">
                                </a>
                                <h2>
                                    <a href="<?php echo url('/thread_views/' . $value['article_id']) ?>"><?php echo $value['title'] ?></a>
                                </h2>
                                <div class="fly-list-info">
                                    标签：<span><?php echo $value['ingredient_list'] ?></span>
                                </div>
                                <span class="fly-list-info">
                                    <i class="layui-icon layui-icon-read" title="查看"></i> <?php echo $value['hits'] ?>
                                    <i class="iconfont icon-zan" style="padding:0px 10px" title="点赞"></i> <?php echo $value['like'] ?>
                                    <i class="iconfont icon-pinglun1" style="padding:0px 10px" title="评论"></i> <?php echo $value['comment'] ?>
                                    <i class="layui-icon layui-icon-star-fill" style="padding:0px 10px" title="收藏"></i> <?php echo $value['fav'] ?>
                                </span>
                                <div class="fly-list-info">
                                    发布日期：<span><?php echo $value['publish_date'] ?></span>
                                </div>
                                <div class="fly-list-badge">
                                    {eq name="$value.top" value="1"}
                                    <span class="layui-badge layui-bg-black">置顶</span>
                                    {/eq}
                                    {eq name="$value.status" value="1"}
                                    <span class="layui-badge layui-bg-red">精帖</span>
                                    {/eq}
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                    <div style="text-align: center;padding: 30px 0;">
                        <?php echo $pager; ?>
                    </div>
                <?php } else { ?>
                    <div class="fly-none">没有相关数据</div>  
                <?php } ?>
            </div>
        </div>
        <div class="layui-col-md4">
            {include file="index/inc_week_hot" /}
            <div class="fly-panel">
                <div class="fly-panel-title">
                    诚邀入住
                </div>
                <div class="fly-panel-main">
                    <a href="#" onclick="layer.alert('发送邮件至：lexiangtu@gmail.com<br> 邮件标题为：申请乐享图社区友链', {title: '申请友链'});" class="fly-zanzhu" style="background-color: #393D49;">虚席以待</a>
                </div>
            </div>
            <div class="fly-panel" >
                <div class="fly-panel-title">
                    扫码下载APP
                </div>
                <div class="fly-panel-main" style="padding: 20px 0; text-align: center;">
                    <img src="__THEME__/images/erweima.png" style="max-width: 100%;" alt="乐享图">
                </div>
                <div class="fly-panel-main" style="text-align: center;">
                    <a class="layui-btn layui-btn-radius layui-btn-danger" href="/media/download/lexiangtu/lexiangtu_v1.0.apk">点击下载APP</a>
                </div>
            </div>
            <div class="fly-panel layui-carousel" id="vip-carousel" lay-filter="vip-carousel">
                <div carousel-item="">
                    <?php if($user_level < 2) { ?>
                        <div style="padding: 0" class="pricing-wco-seven bg-blue">
                            <div class="pricing-title">
                                <div class="name">月费会员</div>
                                <div class="pricing-price">
                                    <span class="pricing-price-unit">￥</span>18
                                    <span class="pricing-price-time">  / 月</span>
                                </div>
                                <div class="pricing-flow">免费在线预览所有图集</div>
                                <div class="pricing-flow">原版图集：支持下载</div>
                                <div class="pricing-flow">打包下载：否</div>
                                <div class="pricing-flow">精彩视频：无权限</div>
                                <div class="pricing-flow">私人定制：否</div>
                                <div class="pricing-flow">每日可下载数：5 个</div>
                            </div>
                            <a target="_self" href="/order/purchase/2">
                                <div class="pricing-btn pricing-btn-4">选择升级</div>
                            </a>
                        </div>
                    <?php } ?>
                    <?php if($user_level < 3) { ?>
                        <div style="padding: 0" class="pricing-wco-senior">
                            <div class="pricing-title">
                                <div class="name">年费会员</div>
                                <div class="pricing-price">
                                    <span class="pricing-price-unit">￥</span>88
                                    <span class="pricing-price-time">  / 年</span>
                                </div>
                                <div class="pricing-flow">免费在线预览所有图集</div>
                                <div class="pricing-flow">原版图集：支持下载</div>
                                <div class="pricing-flow">打包下载：否</div>
                                <div class="pricing-flow">视频写真：支持下载</div>
                                <div class="pricing-flow">私人定制：否</div>
                                <div class="pricing-flow">每日可下载数：20 个</div>
                            </div>
                            <a target="_self" href="/order/purchase/3">
                                <div class="pricing-btn pricing-btn-4">选择升级</div>
                            </a>
                        </div>
                    <?php } ?>
                    <?php if($user_level < 4) { ?>
                        <div style="padding: 0" class="pricing-private">
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
                            <a target="_self" href="/order/purchase/4">
                                <div class="pricing-btn pricing-btn-4">选择升级</div>
                            </a>
                        </div>
                    <?php } ?>
                    <?php if($user_level < 5) { ?>
                        <div style="padding: 0" class="pricing-private">
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
                            <a target="_self" href="/order/purchase/5">
                                <div class="pricing-btn pricing-btn-4">选择升级</div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="fly-panel fly-link">
                <h3 class="fly-panel-title">友情链接</h3>
                <dl class="fly-panel-main">
                    <?php
                    $friendlists = get_nav(3);
                    foreach ($friendlists as $key => $value) {
                        ?>
                        <dd><a href="http://www.baidu.com/">百度</a><dd>
                        <?php } ?>
                    <dd><a href="javascript:;" onclick="layer.alert('发送邮件至：lexiangtu@gmail.com<br> 邮件标题为：申请乐享图友链', {title: '申请友链'});" class="fly-link">申请友链</a><dd>
                </dl>
            </div>
        </div>
    </div>
</div>
{/block}

{block name="foot_js"}
<link rel="stylesheet" href="__PUBLIC__/static/phpfly/css/vip_center.css">
<script>
    layui.use(['carousel'], function () {
        //常规轮播
        var carousel = layui.carousel;
        carousel.render({
            elem: '#vip-carousel'
            ,width: '100%'
            ,height: '440px'
            ,interval: 3000
        });
    });
</script>
{/block}