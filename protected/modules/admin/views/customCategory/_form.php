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
    if (!$model->isNewRecord){
        if($model->parent_id != 0){
            $parent_category = CustomCategory::model()->findByAttributes(array('id'=>$model->parent_id));
            if ($parent_category->parent_id != 0) {
                $parent_category2 = CustomCategory::model()->findByPk($parent_category->parent_id);
                $model->subcategory_id = $parent_category->id;
                $model->parent_id = $parent_category2->id;
                $data = CHtml::listData(CustomCategory::model()->findAllByAttributes(array('parent_id' => $parent_category->parent_id, 'status' => 1, 'trash' => 0)), 'id', 'title');
                $display = 'block';
            } else {
                $model->parent_id = $parent_category->id;
                $data = CHtml::listData(CustomCategory::model()->findAll('parent_id ='.$parent_category->id.' AND id!='.$model->id.' AND trash = 0 AND status = 1'), 'id', 'title');
//                $display = 'none';
            }
        }
        else{
            $data = array();
        }
    }
    else {
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

    <div id="subcategory" style="display: <?php echo $display; ?>">
        <?php echo $form->dropDownListRow($model, 'subcategory_id', $data, array('style' => '', 'prompt' => '--- Select Subcategory ---')); ?>
    </div>

    <?php echo $form->dropDownListRow($model, 'status', array('Draft', 'Publish'), array('prompt' => '--- Select Status ---')); ?>

    <div class="form-actions">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update', array('class' => 'btn btn-success')); ?>
        <?php if ($model->isNewRecord) echo CHtml::resetButton('Reset', array('class' => 'btn')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->