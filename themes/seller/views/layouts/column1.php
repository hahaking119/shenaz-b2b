<?php $this->beginContent('//layouts/main'); ?>

<div id="msg"><?php $this->widget('bootstrap.widgets.TbAlert'); ?></div>

<div class="container">
    <div class="login-box">
        <div class="row">
            <div class="span5">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endContent(); ?>