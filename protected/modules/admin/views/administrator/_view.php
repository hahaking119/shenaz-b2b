<?php
/* @var $this AdministratorController */
/* @var $data Administrator */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('administrator_id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->administrator_id), array('view', 'id' => $data->administrator_id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
    <?php echo CHtml::encode($data->email); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('first_name')); ?>:</b>
    <?php echo CHtml::encode($data->first_name); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('middle_name')); ?>:</b>
    <?php echo CHtml::encode($data->middle_name); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('last_name')); ?>:</b>
    <?php echo CHtml::encode($data->last_name); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
    <?php echo CHtml::encode(($data->status == 1) ? 'Active' : 'Inactive'); ?>
    <br />

    <?php /*
      <b><?php echo CHtml::encode($data->getAttributeLabel('role_id')); ?>:</b>
      <?php echo CHtml::encode($data->role_id); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('activation_key')); ?>:</b>
      <?php echo CHtml::encode($data->activation_key); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('activation_status')); ?>:</b>
      <?php echo CHtml::encode($data->activation_status); ?>
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