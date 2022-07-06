{extend name="base:base" /}
{block name="body"}
{include file="index/column_nav" /}
<div class="layui-container">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md8">
            <div class="fly-panel">
                <div class="fly-panel-title fly-filter">
                    <a>推荐</a>
                    <?php if ($sign_info['num'] > 0) { ?>
                        <a href="#" class="layui-hide-sm layui-show-xs-block fly-right" >已签到</a>
                    <?php } else { ?>
                        <a href="#signin" class="layui-hide-sm layui-show-xs-block fly-right" id="LAY_gosignin" style="color: #FF5722;">去签到</a>
                    <?php } ?>
                </div>
                <ul class="fly-list">
                    <?php
                    foreach ($lists_top4 as $key => $value) {
                        ?>
                        <li>
                            <a href="<?php echo url('/thread_views/' . $value['article_id']) ?>" class="fly-avatar">
                                <img style="width:75px;height:110px" src="/static/phpfly/images/loadding.gif" lay-src="__MEDIA_URL__<?php echo $value['image']; ?>">
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
            </div>
            <div class="fly-panel" style="margin-bottom: 0;">
                <div class="fly-panel-title fly-filter">
                    <a href="<?php
                    echo url('/thread/' . request()->param('alias'));
                    ?>" <?php
                       if (empty(request()->param('type'))) {
                           echo ' class="layui-this" ';
                       }
                       ?>>综合</a>                    
                    <span class="fly-mid"></span>
                    <a href="<?php
                    echo url('/thread/all/wonderful');
                    ?>" <?php
                       if (request()->param('type') == 'wonderful') {
                           echo ' class="layui-this" ';
                       }
                       ?>>精华</a>                    
                </div>
                <ul class="fly-list"> 
                    <?php
                    foreach ($lists_thread20 as $key => $value) {
                        ?>
                        <li>
                            <a href="<?php echo url('/thread_views/' . $value['article_id']) ?>" class="fly-avatar">
                                <img style="width:75px;height:110px" src="/static/phpfly/images/loadding.gif" lay-src="__MEDIA_URL__<?php echo $value['image']; ?>">
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
                <div style="text-align: center">
                    <div class="laypage-main">
                        <a href="/thread/all/0/page/2.html" class="laypage-next">查看更多</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-md4">
            <div class="fly-panel">
                <h3 class="fly-panel-title">温馨通道</h3>
                <ul class="fly-panel-main fly-list-static">
                    <?php
                    foreach (get_nav(5) as $key => $value) {
                        ?>
                        <li><a href="<?php echo url('/thread_views/' . $value['article_id']) ?>" target="<?php echo $value['title'] ?>"><?php echo $value['title'] ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="fly-panel fly-signin">
                <div class="fly-panel-title">
                    签到
                    <i class="fly-mid"></i> 
                    <a href="javascript:;" class="fly-link" id="LAY_signinHelp">说明</a>
                    <i class="fly-mid"></i> 
                    <a href="javascript:;" class="fly-link" id="LAY_signinTop">活跃榜<span class="layui-badge-dot"></span></a>
                    <span class="fly-signin-days">已连续签到 {$sign_info['num']} 天</span>
                </div>
                <div class="fly-panel-main fly-signin-main">
                    <?php
                    if ($sign_info['num'] > 0) {
                        ?>
                        <button class="layui-btn layui-btn-disabled" id="LAY_signin">今日已签到</button>
                    <?php } else { ?>
                        <button class="layui-btn layui-btn-danger" id="LAY_signin">今日签到</button>
                    <?php } ?>   
                    <span id="sign_tip">{$sign_tip}</span>             
                </div>
                {include file="index/sign_box" /}
            </div>
            <div class="fly-panel fly-rank fly-rank-reply" id="LAY_replyRank">
                <h3 class="fly-panel-title">回贴周榜</h3>
                <dl>
                  <!--<i class="layui-icon fly-loading">&#xe63d;</i>-->
                    <?php
                    foreach ($lists_member12 as $key => $value) {
                        ?>
                        <dd>
                            <a href="<?php echo url('/portal/' . $value['member_id']) ?>" class="fly-link">
                                <img src="<?php echo $value['avatar']; ?>">
                                <cite><?php echo $value['nickname'] ?></cite>
                                <i><?php echo $value['count'] ?>次评论</i>
                            </a>
                        </dd>
                    <?php } ?>
                </dl>
            </div>
            {include file="index/inc_week_hot" /}
            <div class="fly-panel">
                <div class="fly-panel-title">
                    这里可作为广告区域
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
                    $friendlists = [[ 'title' => '百度']];
                    foreach ($friendlists as $key => $value) {
                        ?>
                        <dd style="color: red"><a href="http://www.baidu.com/" target="_blank"><?php echo $value['title'] ?></a><dd>
                    <?php } ?>
                    <dd><a href="javascript:;" onclick="layer.alert('发送邮件至：lexiangtu@gmail.com<br> 邮件标题为：申请乐享图社区友链', {title: '申请友链'});" class="fly-link">申请友链</a><dd>
                </dl>
            </div>
        </div>
    </div>
</div>
{/block}
{block name="foot_js"}
<link rel="stylesheet" href="__THEME__/css/calendar.css" />
<link rel="stylesheet" href="__PUBLIC__/static/phpfly/css/vip_center.css">
<script>
    layui.use(['carousel', 'flow'], function () {
        var flow = layui.flow;
        //当你执行这样一个方法时，即对页面中的全部带有lay-src的img元素开启了懒加载（当然你也可以指定相关img）
        flow.lazyimg();
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