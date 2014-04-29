<?php
/* @var $this AdministratorController */
/* @var $model Administrator */

$this->breadcrumbs = array(
    'Administrators' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List Administrator', 'url' => array('index')),
    array('label' => 'Manage Administrators', 'url' => array('admin')),
);
?>

<h1>Add Administrator</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>