{extend name="base:base" /}
{block name="body"}
{include file="index/column_nav" /}
<div class="layui-container">
    <div class="layui-carousel" id="vip_cneter">
        <div carousel-item style="background-color: blue">
            <?php foreach ($goods as $item) { ?>
                <div style="text-align: center">
                    <?php echo $item['name']; ?>
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