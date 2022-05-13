{extend name="base:base" /}
{block name="body"}
{include file="index/column_nav" /}
<div class="layui-container">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md8 content detail">
            <div class="fly-panel detail-box">
                <h1><?php echo $title ?></h1>
                <div class="fly-detail-info">
                    <span class="layui-badge layui-bg-green fly-detail-column"><?php echo $column_title ?></span>
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
                <div class="detail-about" style="line-height: 16px;">
                    <?php foreach ($thread_ingredients as $value) { ?>
                        <p><?php echo $value['name'] . $value['dosage']; ?></p>
                    <?php } ?>
                </div>
                <div class="layui-btn-container fly-detail-admin" id="LAY_jieAdmin" data-id="<?php echo $id ?>"></div>
                <div class="detail-body photos">
                    <?php echo $content; ?>
                </div>
                <div class="photos">
                    <?php foreach ($thread_images as $value) { ?>
                        <img src="<?php echo $value['image']; ?>">
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