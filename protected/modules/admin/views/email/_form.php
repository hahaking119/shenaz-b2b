<?php
/* @var $this EmailController */
/* @var $model Email */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'email-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'from'); ?>
		<?php echo $form->textField($model,'from',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'from'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'to'); ?>
		<?php echo $form->textField($model,'to'); ?>
		<?php echo $form->error($model,'to'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'message'); ?>
		<?php echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'message'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'attachment'); ?>
		<?php echo $form->textField($model,'attachment',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'attachment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'trash'); ?>
		<?php echo $form->textField($model,'trash'); ?>
		<?php echo $form->error($model,'trash'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sent'); ?>
		<?php echo $form->textArea($model,'sent',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'sent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
		<?php echo $form->error($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modified_at'); ?>
		<?php echo $form->textField($model,'modified_at'); ?>
		<?php echo $form->error($model,'modified_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'trashed_at'); ?>
		<?php echo $form->textField($model,'trashed_at'); ?>
		<?php echo $form->error($model,'trashed_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sent_at'); ?>
		<?php echo $form->textField($model,'sent_at'); ?>
		<?php echo $form->error($model,'sent_at'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->