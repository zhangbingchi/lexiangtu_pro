<div class="fly-header layui-bg-black">
    <div class="layui-container">
        <ul class="layui-nav">
            <li class="layui-nav-item">
                <a href="/media/download/lexiangtu/lexiangtu_v1.0.apk" style="color:red;">乐享图</a>
            </li>
            <li class="layui-nav-item">
                <a href="/media/download/lexiangtu/lexiangtu_v1.0.apk" style="color:yellow;">
                    <i class="iconfont icon-iconmingxinganli"></i>会员中心
                </a>
            </li>
            <li class="layui-nav-item layui-hide-xs">
                <a href="/media/download/lexiangtu/lexiangtu_v1.0.apk" style="color:yellow;">
                    <i class="iconfont icon-jiaoliu"></i>APP下载
                </a>
            </li>
        </ul>
        <ul class="layui-nav fly-nav-user">
            <?php
            if (is_array($member = member_is_login())) {
                ?>
                <!-- 登入后的状态 -->            
                <li class="layui-nav-item">
                    <a class="fly-nav-avatar" href="javascript:;">
                        <cite class="layui-hide-xs"><?php echo $member['nickname'] ?></cite>
                        {notempty name="$member.identification"}
                        <i class="iconfont icon-renzheng layui-hide-xs" title="认证信息：{$member.identification}"></i>
                        {/notempty}
                        {gt name="$member.vip" value="0"}
                        <i class="layui-badge fly-badge-vip layui-hide-xs">VIP{$member.vip}</i>
                        {/gt}
                        <img src="<?php
            if ($member['avatar'])
                echo res_http($member['avatar']);
            else
                echo res_http('sex' . $member['sex'] . '.png');
                ?>">
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a href="<?php echo url('index/member/setting') ?>"><i class="layui-icon">&#xe620;</i>基本设置</a></dd>
                        <dd><a href="<?php echo url('index/member/message') ?>"><i class="iconfont icon-tongzhi" style="top: 4px;"></i>我的消息</a></dd>
                        <dd><a href="<?php echo url('/portal/0') ?>"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe68e;</i>我的主页</a></dd>
                        <hr style="margin: 5px 0;">
                        <dd><a href="<?php echo url('index/user/logout') ?>" style="text-align: center;">退出</a></dd>
                    </dl>
                </li>
<?php } else { ?>
                <!-- 未登入的状态 -->
                <li class="layui-nav-item">
                    <a class="iconfont icon-touxiang layui-hide-xs" href="<?php echo url('index/user/login') ?>"></a>
                </li>
                <li class="layui-nav-item">
                    <a href="<?php echo url('index/user/login') ?>">登入</a>
                </li>
                <li class="layui-nav-item">
                    <a href="<?php echo url('index/user/reg') ?>">注册</a>
                </li>
                <li class="layui-nav-item layui-hide-xs layui-hide">
                    <a href="/app/qq/" onclick="layer.msg('正在通过QQ登入', {icon: 16, shade: 0.1, time: 0})" title="QQ登入" class="iconfont icon-qq"></a>
                </li>
                <li class="layui-nav-item layui-hide-xs layui-hide">
                    <a href="/app/weibo/" onclick="layer.msg('正在通过微博登入', {icon: 16, shade: 0.1, time: 0})" title="微博登入" class="iconfont icon-weibo"></a>
                </li>
<?php } ?>
        </ul>
    </div>
</div>