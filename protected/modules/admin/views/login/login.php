<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Login',
);
?>

<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'login-form',
        'type' => 'horizontal',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>

    <div class="row">
        <?php echo $form->textFieldRow($model, 'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->passwordFieldRow($model, 'password'); ?>
    </div>

    <div class="row rememberMe">
        <?php // echo $form->checkBox($model, 'rememberMe'); ?>
        <?php // echo $form->label($model, 'rememberMe'); ?>
        <?php // echo $form->error($model, 'rememberMe'); ?>
    </div>

    <div class="form-actions">
        <?php echo CHtml::submitButton('Login', array('class' => 'btn')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
