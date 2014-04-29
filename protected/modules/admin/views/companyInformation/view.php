<?php
/* @var $this CompanyInformationController */
/* @var $model CompanyInformation */

$this->breadcrumbs=array(
	'Company Informations'=>array('index'),
	$model->company_id,
);

$this->menu=array(
	array('label'=>'List CompanyInformation', 'url'=>array('index')),
	array('label'=>'Create CompanyInformation', 'url'=>array('create')),
	array('label'=>'Update CompanyInformation', 'url'=>array('update', 'id'=>$model->company_id)),
	array('label'=>'Delete CompanyInformation', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->company_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CompanyInformation', 'url'=>array('admin')),
);
?>

<h1>View CompanyInformation #<?php echo $model->company_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'company_id',
		'member_id',
		'company_name',
		'slug',
		'logo',
		'banner_image',
		'company_location',
		'country_of_origin',
		'website',
		'established_at',
		'active_business_years',
		'import_export',
		'no_of_staffs',
		'description',
		'status',
		'trash',
		'created_at',
		'modified_at',
		'trashed_at',
	),
)); ?>
