{extend name="base:base" /}
{block name="body"}
{include file="index/column_nav" /}
<div class="layui-container">
    <div class="layui-carousel" id="vip_cneter">
        <div carousel-item>
            <?php foreach ($goods as $item) { ?>
                <div>
                    <a href="order/vip_center/<?php echo $item['id']; ?>">
                        <img src="__THEME__/images/vip_center/<?php echo $item['id']; ?>.png" />
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
{/block}
{block name="foot_js"}
<script>
    layui.use('carousel', function(){
        var carousel = layui.carousel;
        //建造实例
        carousel.render({
            elem: '#vip_cneter'
            ,width: '100%' //设置容器宽度
            ,arrow: 'always' //始终显示箭头
            //,anim: 'updown' //切换动画方式
        });
    });
</script>
{/block}