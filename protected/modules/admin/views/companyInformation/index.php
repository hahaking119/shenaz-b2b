<?php
/* @var $this CompanyInformationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Company Informations',
);

$this->menu=array(
	array('label'=>'Create CompanyInformation', 'url'=>array('create')),
	array('label'=>'Manage CompanyInformation', 'url'=>array('admin')),
);
?>

<h1>Company Informations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
