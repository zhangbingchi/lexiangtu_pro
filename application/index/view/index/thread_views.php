{extend name="base:base" /}
{block name="head"}
<link rel="stylesheet" href="__PUBLIC__/static/phpfly/css/vip_center.css">
{/block}
<style>
    color-red: {
        color: red;
    }
</style>
{block name="body"}
<!--导航 tap-->
<div class="layui-container" style="padding-top: 30px">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md8 content detail">
            <div class="fly-panel detail-box">
                <h1 style="font-size: 18px;line-height: 30px;color: red;"><?php echo $title ?></h1>
                <div class="fly-detail-info">
                    <div class="layui-btn-container">
                        <?php foreach ($thread_tags as $tag) { ?>
                            <a href="<?php echo '/thread/search?keyword='.$tag ?>"
                            <button type="button" class="layui-btn layui-btn-xs layui-btn-normal layui-btn-radius">
                                <?php echo $tag; ?>
                            </button>
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <div class="fly-detail-info">
                    {eq name="top" value="1"}
                    <span class="layui-badge layui-bg-black">置顶</span>
                    {/eq}
                    {eq name="status" value="1"}
                    <span class="layui-badge layui-bg-red">精帖</span>
                    {/eq}
                    <span class="fly-list-nums">
                        <i style="padding: 0 3px 0 10px;" class="layui-icon" title="人气">&#xe705;</i> <?php echo $hits ?>
                        <a href="#comment"><i style="padding: 0 3px 0 10px;" class="iconfont" title="回复">&#xe60c;</i> <?php echo $comment ?></a>
                        <a href="#" ><i style="padding: 0 3px 0 10px;" class="layui-icon thread_zan" title="点赞">&#xe6c6;</i> <?php echo $like ?></a>
                        <a href="#" ><i style="padding: 0 3px 0 10px;" class="layui-icon thread_wish" title="收藏">&#xe67a;</i> <?php echo $fav ?></a>
                    </span>
                </div>
                <span>更新日志：</span>
                <hr class="layui-border-red">
                <div class="detail-about" style="padding: 15px 15px 15px 30px;font-size: 15px;">
                    <?php foreach ($thread_ingredients as $value) { ?>
                        <p style="padding:5px"><?php echo $value['name'] . $value['dosage']; ?></p>
                    <?php } ?>
                </div>
                <br />
                <span>原版资源下载：</span>
                <hr class="layui-border-red">
                <p>
                    <?php if ($level_auth['member_id']) { ?>
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: auto;"><b>用户等级：</b></label>
                            <div class="layui-input-block">
                                <span class="downimgp show_text"> <?php echo $level_auth['user_level'] ?></span>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: auto;"><b>权限说明：</b></label>
                            <div class="layui-input-block">
                                剩余下载：<span class="downimgp show_text"><?php echo $level_auth['allow_count'] ?></span>次，可用 <cite style="color:red;font-size: 18px"><?php echo $user_points ?></cite> 积分
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: auto;"><b>下载链接：</b></label>
                            <?php if ($level_auth['is_down_auth'] ) { ?>
                                <?php if(!empty($baidu_url)) { ?>
                                    <div class="layui-input-block">
                                        <a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger"
                                           href="/thread_down/<?php echo $article_id ?>/" target="_blank">进入下载页面</a>
                                    </div>
                                <?php } else { ?>
                                    <div class="layui-input-block">
                                        <p><span class="downimgp show_text"> 原版资源未上传，请耐心等待！</span>
                                        </p>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <?php if ($source_type == 1) { ?>
                                    <div class="layui-input-block">
                                        <p><span class="show_text">微博网红</span>仅支持限<span class="show_text">年度会员</span>以上权限下载，
                                            您可 <a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger"
                                                 href="/order/purchase/3?article_id=<?php echo $article_id ?>" target="_blank">点击此处</a>
                                            升级会员
                                        </p>
                                    </div>
                                <?php } else { ?>
                                    <div style="style="margin-left: 30px; padding-top:30px"">
                                        <p>可 <a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger"
                                               href="/vip_center" target="_blank"> 升级会员 </a> 或 <a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger"
                                                href="/order/purchase/1?article_id=<?php echo $article_id ?>" target="_blank"> 赞助支持 </a> 下载
                                        </p>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="layui-input-block" style="margin-left: 10px;">
                            <p>可 <a class="layui-btn layui-btn-sm layui-btn-radius"
                                   href="/user/reg" target="_blank"> 注册 </a> 或
                                <a class="layui-btn layui-btn-sm layui-btn-radius"
                                   href="/user/login" target="_blank"> 登录 </a> 直接下载
                            </p>
                        </div>
                    <?php } ?>
                    <div class="sm">
                        <p style=" color: #E62129; ">注：每50积分可兑换下载一套图集，可通过升级会员、签到、点赞、评论、收藏等获取不同积分</p>
                    </div>
                </p>
                <br />
                <span>预览效果：</span>
                <a href="/" class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger" style="float:right;margin-bottom: 5px;">返回首页>></a>
                <hr class="layui-border-red">
                <div style="min-height:15px; text-align:center">
                    <a href="#comment" style="color:red;font-size: 18px">注册7日内每日首次回复可免费下载</a>
                    <br>
<!--                    <span>简介</span>-->
                </div>
                <div class="photos">
                    <?php foreach ($thread_images as $value) { ?>
                        <div class="layui-layer-phimg" style="padding: auto auto">
                            <img style="max-width: 90%;max-height:90%;padding-top: 10px" src="/static/phpfly/images/loadding.gif" lay-src="__MEDIA_URL__/<?php echo $value['image']; ?>">
                        </div>
                    <?php } ?>
                </div>
            </div>
            <!--回复区-->
            <div class="fly-panel detail-box" id="flyReply">
                <fieldset class="layui-elem-field layui-field-title" style="text-align: center;">
                    <legend>回帖</legend>
                </fieldset>
                <ul class="reply" id="reply">
                    <li>
                        <a name="item-1111111111"></a>
                        <div class="detail-about detail-about-reply">
                            <a class="fly-avatar" href="#">
                                <img src="/static/phpfly/images/avatar/root.jpg" alt=" ">
                            </a>
                            <div class="fly-detail-user"><cite>管理员</cite></div>
                            <div class="detail-hits">
                                <span>2000-01-01</span>
                            </div>
                        </div>
                        <div class="detail-body reply-body" style="color: red">新注册用户7日内首次回复后可免费下载</div>
                    </li>
                    <?php if (!empty($lists_comment['total'])) { ?>
                        <?php
                        foreach ($lists_comment['data'] as $key => $value) {
                            ?>
                            <li data-id="<?php echo $value['id'] ?>">
                                <a name="item-1111111111"></a>
                                <div class="detail-about detail-about-reply">
                                    <a class="fly-avatar" href="<?php echo url('/portal/' . $value['member_id']) ?>">
                                        <img src="<?php echo $value['avatar'] ?>" alt=" ">
                                    </a>
                                    <div class="fly-detail-user">
                                        <a href="<?php echo url('/portal/' . $value['member_id']) ?>" class="fly-link">
                                            <cite><?php echo $value['nickname'] ?></cite>       
                                        </a>
                                    </div>
                                    <div class="detail-hits">
                                        <span><?php echo date('Y-m-d H:i:s', $value['create_time']); ?></span>
                                    </div>
                                </div>
                                <div class="detail-body reply-body photos"><?php echo $value['content'] ?></div>
                                <div class="reply-box">
                                    <span class="reply-zan <?php
                                    if (!empty($value['like'])) {
                                        echo 'zanok';
                                    }
                                    ?>" type="zan">
                                        <i class="iconfont icon-zan"></i>
                                        <em><?php echo !empty($value['like'])?$value['like']:''; ?></em>
                                    </span>
                                    <span type="reply">
                                        <i class="iconfont icon-svgmoban53"></i>
                                        回复
                                    </span>
                                    <div class="reply-admin">
                                        {eq name="$value.display_comment_edit" value="1"} <span type="edit">编辑</span> {/eq}
                                        {eq name="$value.display_comment_del" value="1"} <span type="del">删除</span>{/eq}
                                        {eq name="$value.display_comment_accept" value="1"} <span class="reply-accept" type="accept">采纳</span>{/eq}
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                    <?php }?>
                </ul>
                <div class="layui-form layui-form-pane">
                    <form action="<?php echo url('index/index/thread_comment_add') ?>" method="post">
                        <input type="hidden" value="{$id}" name="thread_id" />
                        <div class="layui-form-item layui-form-text">
                            <a name="comment"></a>
                            <div class="layui-input-block">
<!--                                <textarea id="L_content" name="content" required lay-verify="required" placeholder="请输入内容"  class="layui-textarea fly-editor" style="height: 150px;"></textarea>-->
                                <textarea id="L_content" name="content" required lay-verify="required" placeholder="请输入内容"  class="layui-textarea" style="height: 150px;"></textarea>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <input type="hidden" name="jid" value="123">
                            <button class="layui-btn" lay-filter="myform" lay-submit>提交回复</button>
                        </div>
                    </form>
                </div>
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
                                <div class="pricing-flow">微博网红：无权限</div>
                                <div class="pricing-flow">打包下载：否</div>
                                <div class="pricing-flow">私人定制：否</div>
                                <div class="pricing-flow">每日赠送150积分，(可兑换下载数：3个)</div>
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
                                <span class="pricing-price-unit">￥</span>108
                                <span class="pricing-price-time">  / 年</span>
                            </div>
                            <div class="pricing-flow">免费在线预览所有图集</div>
                            <div class="pricing-flow">原版图集：支持下载</div>
                            <div class="pricing-flow">微博网红：支持下载</div>
                            <div class="pricing-flow">打包下载：否</div>
                            <div class="pricing-flow">私人定制：否</div>
                            <div class="pricing-flow">每日赠送1000积分，(可兑换下载数：10个)</div>
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
                            <div class="pricing-flow">微博网红：支持下载</div>
                            <div class="pricing-flow">打包下载：否</div>
                            <div class="pricing-flow">私人定制：否</div>
                            <div class="pricing-flow">每日赠送1000积分，(可兑换下载数：20个)</div>
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
                            <div class="pricing-flow">微博网红：支持下载</div>
                            <div class="pricing-flow">打包下载：支持下载</div>
                            <div class="pricing-flow">私人定制：支持</div>
                            <div class="pricing-flow">每日赠送2500积分，(可兑换下载数：50个)</div>
                        </div>
                        <a target="_self" href="/order/purchase/5">
                            <div class="pricing-btn pricing-btn-4">选择升级</div>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
{/block}
{block name="foot_js"}
<script>
    layui.use(['fly', 'face', 'reply', 'carousel', 'flow'], function () {
        var $ = layui.$
                , reply = layui.reply
                , fly = layui.fly;
        $('.detail-body').each(function () {
            var othis = $(this), html = othis.html();
            othis.html(fly.content(html));
        });

        //当你执行这样一个方法时，即对页面中的全部带有lay-src的img元素开启了懒加载（当然你也可以指定相关img）
        var flow = layui.flow;
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