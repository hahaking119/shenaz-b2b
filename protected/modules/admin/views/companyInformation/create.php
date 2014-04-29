<?php
/* @var $this CompanyInformationController */
/* @var $model CompanyInformation */

$this->breadcrumbs=array(
	'Company Informations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CompanyInformation', 'url'=>array('index')),
	array('label'=>'Manage CompanyInformation', 'url'=>array('admin')),
);
?>

<h1>Create CompanyInformation</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>