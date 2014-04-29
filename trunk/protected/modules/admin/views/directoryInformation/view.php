<?php
/* @var $this DirectoryInformationController */
/* @var $model DirectoryInformation */

$this->breadcrumbs=array(
	'Directory Informations'=>array('index'),
	$model->directory_id,
);

$this->menu=array(
	array('label'=>'List DirectoryInformation', 'url'=>array('index')),
	array('label'=>'Create DirectoryInformation', 'url'=>array('create')),
	array('label'=>'Update DirectoryInformation', 'url'=>array('update', 'id'=>$model->directory_id)),
	array('label'=>'Delete DirectoryInformation', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->directory_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DirectoryInformation', 'url'=>array('admin')),
);
?>

<h1>View DirectoryInformation #<?php echo $model->directory_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'directory_id',
		'company_id',
		'first_name',
		'middle_name',
		'last_name',
		'job_title',
		'image',
		'email',
		'phone',
		'fax',
		'zip_code',
		'address',
		'area',
		'province',
		'country',
		'status',
		'trash',
		'created_at',
		'modified_at',
		'trashed_at',
	),
)); ?>
