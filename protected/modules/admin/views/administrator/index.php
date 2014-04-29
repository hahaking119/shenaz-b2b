<?php
/* @var $this AdministratorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Administrators',
);

$this->menu=array(
	array('label'=>'Add Administrator', 'url'=>array('create')),
	array('label'=>'Manage Administrators', 'url'=>array('admin')),
);
?>

<h1>Administrators</h1>

<?php $this->widget('bootstrap.widgets.TbListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
