<?php
/* @var $this MembershipController */
/* @var $model Membership */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'membership-form',
        'type' => 'horizontal',
        'clientOptions' => array('validateOnSubmit' => true),
        'enableAjaxValidation' => true,
            ));
    ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model, 'title', array('size' => 60, 'maxlength' => 255, 'placeholder' => 'Title')); ?>

    <?php echo $form->textAreaRow($model, 'description', array('rows' => 6, 'cols' => 50, 'placeholder' => 'Description goes here...')); ?>

    <?php echo $form->textFieldRow($model, 'shopfront_limit', array('placeholder' => 'Shopfront Limit')); ?>

    <?php echo $form->textFieldRow($model, 'product_limit', array('placeholder' => 'Maximum Limit to add products')); ?>

    <?php echo $form->dropDownListRow($model, 'status', array('Draft', 'Publish'), array('prompt' => '--- Select Status ---')); ?>

    <div class="form-actions">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update', array('class' => 'btn btn-success')); ?>
        <?php if ($model->isNewRecord) echo CHtml::resetButton('Reset', array('class' => 'btn')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->