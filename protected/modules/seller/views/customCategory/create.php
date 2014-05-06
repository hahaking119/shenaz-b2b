<?php
/* @var $this CustomCategoryController */
/* @var $model CustomCategory */

$this->breadcrumbs=array(
	'Custom Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CustomCategory', 'url'=>array('index')),
	array('label'=>'Manage CustomCategory', 'url'=>array('admin')),
);
?>

<h1>Create Custom Category</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'parentCategories' => $parentCategories,)); ?>