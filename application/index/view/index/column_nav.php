<style>
    /*点击tab页背景色改变，以显眼当前在哪个标签页的主体页面*/
    .layadmin-pagetabs .layui-tab-title li:hover, .layadmin-pagetabs .layui-tab-title li.layui-this{
        background-color: #2F9688;
    }
</style>
<div class="layui-container fly-panel">
    <div class="layui-tab">
        <ul class="layui-clear layui-tab-title">
            <li ><a href="<?php echo url('thread/new')?>" target="_blank">最新动态</a></li>
            <li class="layui-this"><a href="#">秀人摄影</a></li>
            <li><a href="#">精品影集</a></li>
            <li><a href="#">次元少女</a></li>
            <li><a href="<?php echo url('thread/shipin')?>" target="_blank">精彩视频</a></li>
            <li class="layui-show-md-inline-block"><span class="fly-mid"></span></li>
            <!-- 用户登入后显示 -->
            <li class="layui-show-md-inline-block"><a href="<?php echo url('index/member/thread') ?>#type=wish">我收藏的贴</a></li>

<!--            <div class="fly-column-right layui-hide-xs layui-show-md-inline-block fly-search">-->
<!--                <i class="layui-icon"></i>-->
<!--            </div>-->
        </ul>
        <div class="layui-tab-content" style="padding:10px 15px 0px 10px">
            <div class="layui-tab-item layui-btn-container"></div>
            <!--        秀人摄影-->
            <div class="layui-tab-item layui-btn-container layui-show"><?php
                $columns = db('tags')->where('pid', '=', 18)->select();
                foreach ($columns as $key => $value) { ?>
                    <a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-primary" href="<?php echo url('/thread/tags/' . $value['id']) ?>"><?php echo $value['title'] ?></a>
                <?php } ?>
            </div>
            <!--        精品影集-->
            <div class="layui-tab-item layui-btn-container"><?php
                $where = [['pid', '=', 0], ['tag_type', '=', 1]];
                $columns = db('tags')->where($where)->select();
                foreach ($columns as $key => $value) { ?>
                    <a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-primary" href="<?php echo url('/thread/tags/' . $value['id']) ?>"><?php echo $value['title'] ?></a>
                <?php } ?>
            </div>
            <!--        次元少女-->
            <div class="layui-tab-item layui-btn-container"><?php
                $columns = db('tags')->where('pid', '=', 39)->select();
                foreach ($columns as $key => $value) { ?>
                    <a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-primary" href="<?php echo url('/thread/tags/' . $value['id']) ?>"><?php echo $value['title'] ?></a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script>
    //注意：选项卡 依赖 element 模块，否则无法进行功能性操作
    layui.use('element', function(){
        var element = layui.element;

        //…
    });
</script>