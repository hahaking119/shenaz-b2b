<?php
/* @var $this MembershipController */
/* @var $data Membership */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('membership_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->membership_id), array('view', 'id'=>$data->membership_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shopfront_limit')); ?>:</b>
	<?php echo CHtml::encode($data->shopfront_limit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_limit')); ?>:</b>
	<?php echo CHtml::encode($data->product_limit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trash')); ?>:</b>
	<?php echo CHtml::encode($data->trash); ?>
	<br />

	<?php /*
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