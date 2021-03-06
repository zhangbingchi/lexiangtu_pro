{extend name="base:base" /}
{block name="body"}
<div class="layui-container fly-marginTop">
    <div class="fly-panel fly-panel-user" pad20>
        <div class="layui-tab layui-tab-brief" lay-filter="user">
            <ul class="layui-tab-title">
                <li class="layui-this">登入</li>
                <li><a href="reg.html">注册</a></li>
            </ul>
            <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
                <div class="layui-tab-item layui-show">
                    <div class="layui-form layui-form-pane">
                        <form method="post">
                            <div class="layui-form-item">
                                <label for="L_email" class="layui-form-label">邮箱</label>
                                <div class="layui-input-inline">
                                    <input type="text" id="L_email" name="email" required lay-verify="required|email" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label for="L_pass" class="layui-form-label">密码</label>
                                <div class="layui-input-inline">
                                    <input type="password" id="L_pass" name="password" required lay-verify="required" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label for="L_vercode" class="layui-form-label">人类验证</label>
                                <div class="layui-input-inline">
                                    <input type="text" id="L_vercode" name="vercode" required lay-verify="required" placeholder="请回答后面的问题" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-form-mid" style="padding: 0!important;margin-left:0px;">
                                  <img src="{:captcha_src()}" alt="验证码，点击图片可更换" style="cursor: pointer" onclick="this.src='{:captcha_src()}?r='+Math.random() " />
                                </div>
                            </div>
<!--                            <div class="layui-form-item">-->
<!--                                <label class="layui-form-label" style="border-style: initial;background-color: initial;">自动登录：</label>-->
<!--                                <div class="layui-input-block">-->
<!--                                    <input type="checkbox" name="switch" lay-skin="switch" lay-text="ON|OFF" checked>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="layui-form-item">
                                <button class="layui-btn" lay-filter="myform" lay-submit>立即登录</button>
                                <span style="padding-left:20px;">
                                    <a href="<?php echo url('user/forget') ?>">忘记密码？</a>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{/block}
