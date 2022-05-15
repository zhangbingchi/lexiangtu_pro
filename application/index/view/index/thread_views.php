{extend name="base:base" /}
{block name="body"}
{include file="index/column_nav" /}
<div class="layui-container">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md8 content detail">
            <div class="fly-panel detail-box">
                <h1 style="font-size: 18px;line-height: 30px;color: red;"><?php echo $title ?></h1>
                <div class="fly-detail-info">
                    <?php foreach ($thread_tags as $tag) { ?>
                        <a href="<?php echo 'thread/search?keyword='.$tag ?>" class="layui-badge layui-bg-gree fly-detail-column">
                            <?php echo $tag; ?>
                        </a>
                    <?php } ?>
                    {eq name="top" value="1"}
                    <span class="layui-badge layui-bg-black">置顶</span>
                    {/eq}
                    {eq name="status" value="1"}
                    <span class="layui-badge layui-bg-red">精帖</span>
                    {/eq}
                    <span class="fly-list-nums"> 
                        <a href="#comment"><i class="iconfont" title="回答">&#xe60c;</i> <?php echo $comment ?></a>
                        <i class="iconfont" title="人气">&#xe60b;</i> <?php echo $hits ?>
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
                                <?php if(!empty($pay_url)) { ?>
                                    <div class="layui-input-block">
                                        <a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger"
                                           href="/food/down_detail/<?php echo $article_id ?>/" target="_blank">进入下载页面</a>
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
                                    <div class="layui-input-block">
                                        <p>可<a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger"
                                               href="http://show.lexiangtu.top/order/vip_center" target="_blank">升级会员</a>或<a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger"
                                                href="http://show.lexiangtu.top/order/purchase/1?article_id=<?php echo $article_id ?>" target="_blank">购买图集</a>下载
                                        </p>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="layui-input-block" style="margin-left: 10px;">
                            <p>可<a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger"
                                   href="/user/register/" target="_blank">注册</a> 或 <a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger"
                                                                                      href="/user/login/" target="_blank">登录</a>直接下载
                            </p>
                        </div>
                    <?php } ?>
                </p>
                <br />
                <span>预览效果：</span>
                <hr class="layui-border-red">
                <div class="detail-body" style="min-height:30px;">
                    <?php echo $content; ?>
                </div>
                <div class="photos">
                    <?php foreach ($thread_images as $value) { ?>
                            <img style="max-width: 45%;max-height:45%" src="<?php echo 'http://show.lexiangtu.top/media/' . $value['image']; ?>">
                    <?php } ?>
                </div>
            </div>

            <div class="fly-panel detail-box" id="flyReply">
                <fieldset class="layui-elem-field layui-field-title" style="text-align: center;">
                    <legend>回帖</legend>
                </fieldset>
                <ul class="reply" id="reply">
                    <?php
                    if (!empty($lists_comment['total'])) {
                        ?>
                        <?php
                        foreach ($lists_comment['data'] as $key => $value) {
                            ?>
                            <li data-id="<?php echo $value['id'] ?>">
                                <a name="item-1111111111"></a>
                                <div class="detail-about detail-about-reply">
                                    <a class="fly-avatar" href="<?php echo url('/portal/' . $value['member_id']) ?>">
                                        <img src="<?php
                                        if ($value['avatar'])
                                            echo res_http($value['avatar']);
                                        else
                                            echo res_http('sex' . $value['sex'] . '.png');
                                        ?>" alt=" ">
                                    </a>
                                    <div class="fly-detail-user">
                                        <a href="<?php echo url('/portal/' . $value['member_id']) ?>" class="fly-link">
                                            <cite><?php echo $value['nickname'] ?></cite>       
                                        </a>
                                    </div>
                                    <div class="detail-hits">
                                        <span><?php echo $value['create_time'] ?></span>
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
                    <?php } else { ?>
                        <!-- 无数据时 -->
                        <li class="fly-none">消灭零回复</li>
                    <?php } ?>
                </ul>
                <div class="layui-form layui-form-pane">
                    <form action="<?php echo url('index/index/thread_comment_add') ?>" method="post">
                        <input type="hidden" value="{$id}" name="thread_id" />
                        <div class="layui-form-item layui-form-text">
                            <a name="comment"></a>
                            <div class="layui-input-block">
                                <textarea id="L_content" name="content" required lay-verify="required" placeholder="请输入内容"  class="layui-textarea fly-editor" style="height: 150px;"></textarea>
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
                    这里可作为广告区域
                </div>
                <div class="fly-panel-main">
                    <a href="http://layim.layui.com/?from=fly" target="_blank" class="fly-zanzhu" time-limit="2017.09.25-2099.01.01" style="background-color: #5FB878;">LayIM 3.0 - layui 旗舰之作</a>
                </div>
            </div>
            <div class="fly-panel" style="padding: 20px 0; text-align: center;">
                <img src="__THEME__/images/weixin.jpg" style="max-width: 100%;" alt="layui">
                <p style="position: relative; color: #666;">微信扫码关注 layui 公众号</p>
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