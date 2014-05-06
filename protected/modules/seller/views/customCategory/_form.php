<?php
/* @var $this CustomCategoryController */
/* @var $model CustomCategory */
/* @var $form CActiveForm */
?>
<div class="form">

    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'custom-category-form',
        'type' => 'horizontal',
        'enableAjaxValidation' => true,
        'enableClientValidation'=>true,
        'clientOptions' => array('validateOnSubmit' => true),
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->hiddenField($model,'company_id'); ?>

    <?php echo $form->textFieldRow($model, 'title', array('size' => 60, 'maxlength' => 255, 'placeholder' => 'Title')); ?>

    <?php
    if (isset($parentCategories)) {
        $Categories = CHtml::listData($parentCategories, 'category_id', 'title');
        if (!empty($Categories))
            $parentCategories = $Categories;
    } else {
        $parentCategories = array();
    }
    echo $form->dropDownListRow($model, 'parent_id', $parentCategories, array('prompt' => '--- Select Parent Category ---'));
    ?>

    <?php echo $form->dropDownListRow($model, 'status', array(0 => 'Draft', 1 => 'Publish'), array('prompt' => '--- Select Status ---')); ?>

    <div class="form-actions">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update', array('class' => 'btn btn-success')); ?>
        <?php if ($model->isNewRecord) echo CHtml::resetButton('Reset', array('class' => 'btn')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
