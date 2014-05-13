<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
    <div class="row">
        <div class="span3">
            <?php $this->widget('LeftMenu'); ?>
        </div>
        <div class="span9">
            <div id="msg"><?php $this->widget('bootstrap.widgets.TbAlert'); ?></div>
            <?php echo $content; ?>
        </div>
    </div>
</div>

<?php $this->endContent(); ?>