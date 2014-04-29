<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
    <div class="row">
        <div class="span2">
            <?php $this->widget('application.modules.admin.components.AdminLeftColumn'); ?>
        </div>
        <div class="span10">
            <div id="msg"><?php $this->widget('bootstrap.widgets.TbAlert'); ?></div>
            <?php echo $content; ?>
        </div>
    </div>
</div>

<?php $this->endContent(); ?>