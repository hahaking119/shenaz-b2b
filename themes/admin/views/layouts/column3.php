<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
    <div class="row">
        <div class="span2">
            <?php $this->widget('application.modules.admin.components.AdminLeftColumn'); ?>
        </div>
        <div class="span8">
            <div id="msg"><?php $this->widget('bootstrap.widgets.TbAlert'); ?></div>
            <?php echo $content; ?>
        </div>
        <div class="span2">
            <h2>Actions</h2>
            <?php
            $this->widget('zii.widgets.CMenu', array(
                'items' => $this->menu,
                'htmlOptions' => array('class' => 'operations'),
            ));
            ?>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>