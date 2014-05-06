<?php
/* @var $this CustomCategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Custom Categories',
);

$this->menu=array(
	array('label'=>'Create CustomCategory', 'url'=>array('create')),
	array('label'=>'Manage CustomCategory', 'url'=>array('admin')),
);
?>

<h1>Custom Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
