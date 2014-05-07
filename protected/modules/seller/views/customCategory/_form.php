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
    if (!$model->isNewRecord) {
        $parent_category = Category::model()->findByPk($model->parent_id);
        if ($parent_category->parent_id !== 0) {
            $model->subcategory_id = $model->parent_id;
            $model->parent_id = $parent_category->parent_id;
            $data = CHtml::listData(Category::model()->findAllByAttributes(array('parent_id' => $parent_category->parent_id)), 'category_id', 'title');
            $display = 'block';
        } else {
            $display = 'none';
        }
    } else {
        $data = array();
        $display = 'none';
    }
    echo $form->dropDownListRow($model, 'parent_id', $parentCategories, array('prompt' => '--- Select Parent Category ---',
        'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('listSubCategories'),
            'update' => '#CustomCategory_subcategory_id',
            'complete' => '$("#subcategory").css("display","block")',
            'data' => array('id' => 'js:this.value'),
        )
        ));
    ?>
    <div id="subcategory" style="display: <?php echo $display; ?>">
        <?php echo $form->dropDownListRow($model, 'subcategory_id', $data, array('style' => '')); ?></div>

    <?php echo $form->dropDownListRow($model, 'status', array(0 => 'Draft', 1 => 'Publish'), array('prompt' => '--- Select Status ---')); ?>

    <div class="form-actions">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update', array('class' => 'btn btn-success')); ?>
        <?php if ($model->isNewRecord) echo CHtml::resetButton('Reset', array('class' => 'btn')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->