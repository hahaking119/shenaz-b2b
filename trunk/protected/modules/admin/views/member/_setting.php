<h1>Setting</h1>
<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'setting-form',
        'type' => 'horizontal',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'enableAjaxValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true),
            ));
    ?>
    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->dropDownListRow($model, 'membership_id', CHtml::listData($membership, 'membership_id', 'title'), array('prompt' => '--- select Membership Type ---')); ?>
    <?php echo $form->dropDownListRow($model, 'theme', array('Default', 'Classic'), array('prompt' => '--- Select Theme ---')); ?>
    <?php echo $form->dropDownListRow($model, 'currency', array('Rand', 'US Dollar', 'Pound', 'Euro'), array('prompt' => '--- Select Default Currency ---')); ?>
    <div class="form-actions">
        <?php echo CHtml::submitButton('Update', array('class' => 'btn btn-success')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
