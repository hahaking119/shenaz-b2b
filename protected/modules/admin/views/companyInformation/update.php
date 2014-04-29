<?php
/* @var $this CompanyInformationController */
/* @var $model CompanyInformation */

$this->breadcrumbs=array(
	'Company Informations'=>array('index'),
	$model->company_id=>array('view','id'=>$model->company_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CompanyInformation', 'url'=>array('index')),
	array('label'=>'Create CompanyInformation', 'url'=>array('create')),
	array('label'=>'View CompanyInformation', 'url'=>array('view', 'id'=>$model->company_id)),
	array('label'=>'Manage CompanyInformation', 'url'=>array('admin')),
);
?>

<h1>Update CompanyInformation <?php echo $model->company_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>