<?php
/* @var $this CompanyInformationController */
/* @var $data CompanyInformation */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->company_id), array('view', 'id'=>$data->company_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('member_id')); ?>:</b>
	<?php echo CHtml::encode($data->member_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_name')); ?>:</b>
	<?php echo CHtml::encode($data->company_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('slug')); ?>:</b>
	<?php echo CHtml::encode($data->slug); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('logo')); ?>:</b>
	<?php echo CHtml::encode($data->logo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('banner_image')); ?>:</b>
	<?php echo CHtml::encode($data->banner_image); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_location')); ?>:</b>
	<?php echo CHtml::encode($data->company_location); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('country_of_origin')); ?>:</b>
	<?php echo CHtml::encode($data->country_of_origin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('website')); ?>:</b>
	<?php echo CHtml::encode($data->website); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('established_at')); ?>:</b>
	<?php echo CHtml::encode($data->established_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active_business_years')); ?>:</b>
	<?php echo CHtml::encode($data->active_business_years); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('import_export')); ?>:</b>
	<?php echo CHtml::encode($data->import_export); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('no_of_staffs')); ?>:</b>
	<?php echo CHtml::encode($data->no_of_staffs); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trash')); ?>:</b>
	<?php echo CHtml::encode($data->trash); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_at')); ?>:</b>
	<?php echo CHtml::encode($data->modified_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trashed_at')); ?>:</b>
	<?php echo CHtml::encode($data->trashed_at); ?>
	<br />

	*/ ?>

</div>