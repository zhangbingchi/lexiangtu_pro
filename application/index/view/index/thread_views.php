{extend name="base:base" /}
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
                                今日剩余下载：<span class="downimgp show_text"><?php echo $level_auth['allow_count'] ?></span>次
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
                                        <p><span class="show_text">视频资源</span>仅支持限<span class="show_text">年费会员</span>以上权限下载，
                                            您可 <a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger"
                                                 href="/order/purchase/3?article_id=<?php echo $article_id ?>" target="_blank">点击此处</a>
                                            升级会员
                                        </p>
                                    </div>
                                <?php } else { ?>
                                    <div style="style="margin-left: 30px; padding-top:30px"">
                                        <p>可 <a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger"
                                               href="/vip_center" target="_blank"> 升级会员 </a> 或 <a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger"
                                                href="/order/purchase/1?article_id=<?php echo $article_id ?>" target="_blank"> 购买图集 </a> 下载
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
                </p>
                <br />
                <span>预览效果：</span>
                <a href="/" class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger">返回首页>></a>
                <hr class="layui-border-red">
                <div style="min-height:15px; text-align:center">
                    <a href="#comment" style="color:red;font-size: 18px">注册7日内每日首次回复可免费下载</a>
                    <br>
                    <span><?php echo $content; ?></span>
                </div>
                <div class="photos">
                    <?php foreach ($thread_images as $value) { ?>
                        <div class="layui-layer-phimg" style="padding: auto auto">
                            <img style="max-width: 90%;max-height:90%;padding-top: 10px" src="__MEDIA_URL__/<?php echo $value['image']; ?>">
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
                    <a href="" target="_blank" class="fly-zanzhu" style="background-color: #393D49;">虚席以待</a>
                </div>
            </div>
            <div class="fly-panel" >
                <div class="fly-panel-title">
                    扫码下载APP
                </div>
                <div class="fly-panel-main" style="padding: 20px 0; text-align: center;">
                    <img src="__THEME__/images/erweima.png" style="max-width: 100%;" alt="乐享图">
                </div>
            </div>
        </div>
    </div>
</div>
{/block}
{block name="foot_js"}
<script>
    layui.use(['fly', 'face', 'reply'], function () {
        var $ = layui.$
                , reply = layui.reply
                , fly = layui.fly;
        $('.detail-body').each(function () {
            var othis = $(this), html = othis.html();
            othis.html(fly.content(html));
        });
    });
</script>
{/block}