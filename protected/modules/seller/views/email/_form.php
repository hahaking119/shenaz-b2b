<?php
/* @var $this EmailController */
/* @var $model Email */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'email-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal'
            ));
    ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="control-group ">
            <div class="control-label"><?php echo $form->labelEx($model, 'to'); ?></div>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'to'); ?>
                <?php echo Member::model()->findByPk($model->to)->email; ?>
                <?php echo $form->error($model, 'to'); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <?php echo $form->textFieldRow($model, 'subject', array('size' => 60, 'maxlength' => 255, 'value' => 'B2B Reply From - '.CompanyInformation::model()->findByAttributes(array('member_id' => $model->to))->company_name)); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'message'); ?>
        <?php echo $form->textArea($model, 'message', array('rows' => 10, 'cols' => 100, 'class' => 'span6', 'value' => '')); ?>
        <?php echo $form->error($model, 'message'); ?>
    </div>

    <!--    <div class="row">
    <?php echo $form->labelEx($model, 'attachment'); ?>
    <?php echo $form->textField($model, 'attachment', array('size' => 60, 'maxlength' => 255)); ?>
    <?php echo $form->error($model, 'attachment'); ?>
        </div>-->

    <div class="form-actions">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Send' : 'Send', array('class' => 'btn')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->