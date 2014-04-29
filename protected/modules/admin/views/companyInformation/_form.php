<?php
/* @var $this CompanyInformationController */
/* @var $model CompanyInformation */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-information-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'member_id'); ?>
		<?php echo $form->textField($model,'member_id'); ?>
		<?php echo $form->error($model,'member_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'company_name'); ?>
		<?php echo $form->textField($model,'company_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'company_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'slug'); ?>
		<?php echo $form->textField($model,'slug',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'slug'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'logo'); ?>
		<?php echo $form->textField($model,'logo',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'logo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'banner_image'); ?>
		<?php echo $form->textField($model,'banner_image',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'banner_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'company_location'); ?>
		<?php echo $form->textField($model,'company_location',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'company_location'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'country_of_origin'); ?>
		<?php echo $form->textField($model,'country_of_origin',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'country_of_origin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'website'); ?>
		<?php echo $form->textField($model,'website',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'website'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'established_at'); ?>
		<?php echo $form->textField($model,'established_at'); ?>
		<?php echo $form->error($model,'established_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'active_business_years'); ?>
		<?php echo $form->textField($model,'active_business_years'); ?>
		<?php echo $form->error($model,'active_business_years'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'import_export'); ?>
		<?php echo $form->textField($model,'import_export'); ?>
		<?php echo $form->error($model,'import_export'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'no_of_staffs'); ?>
		<?php echo $form->textField($model,'no_of_staffs'); ?>
		<?php echo $form->error($model,'no_of_staffs'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
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

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->