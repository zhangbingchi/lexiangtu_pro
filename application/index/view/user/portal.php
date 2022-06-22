{extend name="base:base" /}
{block name="body"}
<div class="fly-home fly-panel" style="background-image: url();">
    <img src="<?php echo $avatar ?>" alt="<?php echo $nickname ?>">
    {notempty name="identification"}
    <i class="iconfont icon-renzheng" title="{$identification}"></i>
    {/notempty}
    <h1>
        {$nickname}
        {eq name="sex" value="1"}
        <i class="iconfont icon-nv"></i> 
        {else/}      
        <i class="iconfont icon-nan"></i>
        {/eq}
        {gt name="user_level" value="1"}
        <i class="layui-badge fly-badge-vip">VIP{$user_level}</i>
        {/gt}
        <!--
        <span style="color:#c00;">（管理员）</span>
        <span>（该号已被封）</span>
        -->
    </h1>
    {notempty name="identification"}
    <p style="padding: 10px 0; color: #5FB878;">认证信息：{$identification}</p>
    {/notempty}
    <p class="fly-home-info">
        <i class="layui-icon layui-icon-snowflake" title="积分"></i><span style="color: #FF7200;"><?php echo $points ?> 积分</span>
        <i class="iconfont icon-shijian"></i><span><?php echo date('Y-m-d H:i:s', $create_time) ?> 加入</span>
        <?php if ($city) { ?>
            <i class="iconfont icon-chengshi"></i><span>来自<?php echo $city ?></span>
        <?php } ?>
    </p>
    <?php if ($signature) { ?>
        <p class="fly-home-sign">（<?php echo $signature ?>）</p>
    <?php } ?>
    <div class="fly-sns" data-id="{$id}">       
        <?php
        if ($id != session('member.id')) {
            switch ($follow_type) {
                case 1:
                    $follow_title = '已关注';
                    break;
                case 2:
                    $follow_title = 'TA关注了我';
                    break;
                case 3:
                    $follow_title = '好友';
                    break;
                default:
                    $follow_title = '关注TA';
                    break;
            }
            ?>
            <a href="javascript:;" class="layui-btn layui-btn-primary fly_follow" data-type="follow">{$follow_title}</a>        
            <a href="javascript:;" class="layui-btn layui-btn-normal fly_message" data-type="message">私信TA</a>
        <?php } ?>
    </div>
</div>
<div class="layui-container">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md6 fly-home-da">
            <div class="fly-panel">
                <h3 class="fly-panel-title"><?php echo $nickname ?> 最近的回复</h3>
                <ul class="home-jieda">
                    <?php
                    if (count($recent_comment_lists) > 0) {
                        foreach ($recent_comment_lists as $key => $value) {
                            ?>
                            <li>
                                <p>
                                    <span><?php echo date('Y-m-d H:i:s', $value['create_time']) ?></span>
                                    在<a href="<?php echo url('/thread_views/' . $value['article_id']) ?>" target="_blank"><?php echo $value['title'] ?></a>中回复：
                                </p>
                                <div class="home-dacontent"><?php echo $value['content'] ?></div>
                            </li>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><span>没有回答任何问题</span></div> 
                    <?php } ?>
                </ul>
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
        $('.home-dacontent').each(function () {
            var othis = $(this), html = othis.html();
            othis.html(fly.content(html));
        });
    });
</script>
{/block}