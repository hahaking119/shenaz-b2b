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
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'enableAjaxValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true),
            ));
    ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model, 'title', array('size' => 60, 'maxlength' => 255)); ?>

    <?php
    if (isset($parentCategories)) {
        $Categories = CHtml::listData($parentCategories, 'id', 'title');
        if (!empty($Categories))
            $parentCategories = $Categories;
    } else {
        $parentCategories = array();
    }
    if (!$model->isNewRecord) {
        $isParent = CustomCategory::model()->findByPk($model->parent_id);
        if ($isParent->parent_id != 0) {
            $model->subcategory_id = $model->parent_id;
            $model->parent_id = $isParent->parent_id;
            $data = CHtml::listData(CustomCategory::model()->findAllByAttributes(array('parent_id' => $isParent->parent_id)), 'category_id', 'title');
            $display = 'block';
        } else {
            $display = 'none';
        }
    } else {
        $data = array();
        $display = 'none';
    }
    echo $form->dropDownListRow($model, 'parent_id', array(0 => 'Parent Category') + $parentCategories, array('prompt' => '--- Select Parent Category ---',
        'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('listSubCategories'),
            'update' => '#CustomCategory_subcategory_id',
            'complete' => '$("#subcategory").css("display","block")',
            'data' => array('id' => 'js:this.value'),
        )
    ));
    ?>

    <div id="subcategory" style="display: <?php echo $display; ?>"><?php echo $form->dropDownListRow($model, 'subcategory_id', $data, array('style' => '')); ?></div>

    <?php echo $form->dropDownListRow($model, 'status', array('Draft', 'Publish'), array('prompt' => '--- Select Status ---')); ?>

    <div class="form-actions">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update', array('class' => 'btn btn-success')); ?>
        <?php if ($model->isNewRecord) echo CHtml::resetButton('Reset', array('class' => 'btn')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->