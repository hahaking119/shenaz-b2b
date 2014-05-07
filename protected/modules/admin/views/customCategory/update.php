<?php
/* @var $this CustomCategoryController */
/* @var $model CustomCategory */

$this->breadcrumbs = array(
    'Custom Categories' => array('index'),
    $model->title => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => 'List CustomCategory', 'url' => array('index')),
    array('label' => 'Create CustomCategory', 'url' => array('create')),
    array('label' => 'View CustomCategory', 'url' => array('view', 'id' => $model->id)),
    array('label' => 'Manage CustomCategory', 'url' => Yii::app()->createAbsoluteUrl('admin/customCategory/admin/id/' . $model->company_id)),
);
?>

<h1>Update Custom Category <?php echo $model->title; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model, 'parentCategories' => $parentCategories)); ?>