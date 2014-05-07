<?php
/* @var $this CustomCategoryController */
/* @var $model CustomCategory */

$this->breadcrumbs = array(
    'Custom Categories' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List CustomCategory', 'url' => array('index')),
    array('label' => 'Manage CustomCategory', 'url' => Yii::app()->createAbsoluteUrl('admin/customCategory/admin/id/'.$id)),
);
?>

<h1>Create Custom Category</h1>

<?php echo $this->renderPartial('_form', array('model' => $model, 'parentCategories' => $parentCategories)); ?>