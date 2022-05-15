{extend name="base:base" /}
{block name="body"}
{include file="index/column_nav" /}
<div class="layui-container">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md8">
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
                    echo url('/thread/' . request()->param('alias') . '/wonderful');
                    ?>" <?php
                       if (request()->param('type') == 'wonderful') {
                           echo ' class="layui-this" ';
                       }
                       ?>>精华</a>
                </div>
                <?php if ($count) { ?>
                    <ul class="fly-list">
                        <?php
                        foreach ($lists as $key => $value) {
                            ?>
                            <li>
                                <a href="<?php echo url('/thread_views/' . $value['id']) ?>" class="fly-avatar">
                                    <img style="width:75px;height:110px" src="__MEDIA_URL__<?php echo $value['image']; ?>">
                                </a>
                                <h2>
                                    <a href="<?php echo url('/thread_views/' . $value['id']) ?>"><?php echo $value['title'] ?></a>
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
                    这里可作为广告区域
                </div>
                <div class="fly-panel-main">
                    <a href="" target="_blank" class="fly-zanzhu" style="background-color: #393D49;">虚席以待</a>
                </div>
            </div>
            <div class="fly-panel fly-link">
                <h3 class="fly-panel-title">友情链接</h3>
                <dl class="fly-panel-main">
                    <?php
                    $friendlists = get_nav(3);
                    foreach ($friendlists as $key => $value) {
                        ?>
                        <dd><a href="http://www.layui.com/" target="_blank"><?php echo $value['title'] ?></a><dd>
                        <?php } ?>
                    <dd><a href="javascript:;" onclick="layer.alert('发送邮件至：bjphper@qq.com<br> 邮件标题为：申请phpFly社区友链', {title: '申请友链'});" class="fly-link">申请友链</a><dd>
                </dl>
            </div>
        </div>
    </div>
</div>
{/block}