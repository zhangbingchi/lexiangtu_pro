{extend name="base:base" /}
{block name="body"}

<!--导航 tap-->
<div class="layui-container">
    <center>
        <span style="padding: 10px 0;line-height: 30px;">
            <a href="thread_view/<?php echo $article_id; ?>" target="_self" style="color: red;"><?php echo $article_name ?></a>
        </span>
    </center>
    <div class="page-content">

        <?php if ($is_down_auth) { ?>
            <h4 style="border-bottom: 1px solid #eaeaea;padding: 10px 0;">
                <span>下载地址：</span>
            </h4>
            <br>
            <div style=" padding-bottom: 10px; " class="msg">
                <p>百度云地址：
                    <button class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger">
                        <a href="<?php echo $baidu_url . '?pwd='. $baidu_code; ?>" target="_blank">点击下载</a>
                    </button>
                </p>
                <br>
                <p>提取码：
                    <span ><?php echo $baidu_code; ?></span>
                </p>
                <br>
                <p>解压密码：<?php echo $unzip_password; ?></p>
                <br>
                <p style=" color: #E62129;">备注：请先复制提取码，保存解压密码后再点击下载</p>
            </div>
        <?php } else { ?>
            <h4 style="border-bottom: 1px solid #eaeaea;padding: 10px 0;">
                <span><?php echo $desc; ?></span>
            </h4>
        <?php } ?>
        <h4 style="padding-top:15px;border-bottom: 1px solid #eaeaea;padding: 10px 0;">
            <span>下载说明：</span>
        </h4>
        <br>
        <div style=" padding-bottom: 10px; " class="sm">
            <p>1、为了避免用户恶意下载，月度会员每天最多可以下载5个资源 、年费赞助30个资源、永久赞助50个资源！</p>
            <p style=" color: #E62129;">
                2、<span style="font-weight:800">禁止网站用户以任何形式将写真资源发布出去，违者将永久封禁用户账号！</span>
            </p>
            <p>3、下载文件若出现任何问题可以直接在留言区反馈</p>
            <p>4、下载文件为压缩包，请留意文章中的解压密码</p>
            <p style=" color: #E62129;">5、<span style="font-weight:800">请勿在百度云网盘在线解压，谢谢支持！</span></p>
        </div>
        <h4 style="padding-top:15px;border-bottom: 1px solid #eaeaea;padding: 10px 0;">
            <span>免责声明：</span>
        </h4>
        <br>
        <div class="sm">
            <p style=" color: #E62129; ">声明：本站大部分下载资源收集于网络，只做学习和交流使用，版权归原作者所有，由于未及时购买和付费发生的侵权行为，与本站无关。本站发布的内容若侵犯到您的权益，请联系站长删除，我们将及时处理！</p>
        </div>
    </div>
</div>
{/block}
{block name="foot_js"}