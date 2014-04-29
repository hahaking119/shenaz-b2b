<?php
/* @var $this CustomCategoryController */
/* @var $model CustomCategory */

$this->breadcrumbs=array(
	'Custom Categories'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List CustomCategory', 'url'=>array('index')),
	array('label'=>'Create CustomCategory', 'url'=>array('create')),
	array('label'=>'Update CustomCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CustomCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CustomCategory', 'url'=>array('admin')),
);
?>

<h1>View CustomCategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'company_id',
		'title',
		'slug',
		'parent_id',
		'status',
		'trash',
		'created_at',
		'modified_at',
		'trashed_at',
	),
)); ?>
