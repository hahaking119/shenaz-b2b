<?php
/* @var $this DirectoryInformationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Directory Informations',
);

$this->menu=array(
	array('label'=>'Create DirectoryInformation', 'url'=>array('create')),
	array('label'=>'Manage DirectoryInformation', 'url'=>array('admin')),
);
?>

<h1>Directory Informations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
