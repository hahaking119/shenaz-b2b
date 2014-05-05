<?php if (!$model->isNewRecord) { ?><h1>Edit Custom Category</h1> <?php } ?>
<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'custom-category-form',
        'type' => 'horizontal',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'enableAjaxValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true),
            ));
    ?>
    <?php echo $form->textFieldRow($model, 'title'); ?>
    <?php echo $form->dropDownListRow($model, 'parent_id', array(0 => 'Parent Category') + CHtml::listData($customCategory, 'id', 'title'), array('prompt' => '--- Select Parent Category ---')); ?>
    <?php echo $form->dropDownListRow($model, 'status', array('Draft', 'Publish'), array('prompt' => '--- Select Status ---')); ?>
    <div class="form-actions">
        <?php echo CHtml::submitButton('Create', array('class' => 'btn btn-success')); ?>
        <?php if (!$model->isNewRecord) echo CHtml::link('Trash', Yii::app()->createAbsoluteUrl('admin/members/trash_custom_category/id/' . $model->id), array('class' => 'btn btn-danger')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>