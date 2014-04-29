<?php
/* @var $this MemberController */
/* @var $model Member */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'member-form',
        'type' => 'horizontal',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'enableAjaxValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true),
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model, 'email', array('size' => 60, 'maxlength' => 255, 'placeholder' => 'Email')); ?>

    <?php
    if (!$model->isNewRecord) {
        $password = 'z.$Oq#';
    } else {
        $password = '';
    }
    ?>

    <?php echo $form->passwordFieldRow($model, 'password', array('size' => 40, 'maxlength' => 40, 'placeholder' => 'Password', 'value' => $password)); ?>

    <?php echo $form->passwordFieldRow($model, 'password_text', array('size' => 60, 'maxlength' => 255, 'placeholder' => 'Confirm Password', 'value' => $password)); ?>

    <?php echo $form->textFieldRow($model, 'first_name', array('size' => 60, 'maxlength' => 255, 'placeholder' => 'First Name')); ?>

    <?php echo $form->textFieldRow($model, 'middle_name', array('size' => 60, 'maxlength' => 255, 'placeholder' => 'Middle Name')); ?>

    <?php echo $form->textFieldRow($model, 'last_name', array('size' => 60, 'maxlength' => 255, 'placeholder' => 'Last Name')); ?>

    <?php echo $form->textFieldRow($model, 'phone', array('size' => 60, 'maxlength' => 60, 'placeholder' => 'Phone')); ?>

    <?php echo $form->radioButtonListRow($model, 'business_type', array(2 => 'Buyer', 1 => 'Seller', 0 => 'Both'), array('separator' => '')); ?>

    <?php echo $form->dropDownListRow($model, 'status', array(0 => 'Inactive', 1 => 'Active'), array('prompt' => '--- Select Status ---')); ?>

    <div class="form-actions">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('class' => 'btn btn-success')); ?>
        <?php if ($model->isNewRecord) echo CHtml::resetButton('Reset', array('class' => 'btn')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->