<?php
/* @var $this DirectoryInformationController */
/* @var $model DirectoryInformation */

$this->breadcrumbs=array(
	'Directory Informations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DirectoryInformation', 'url'=>array('index')),
	array('label'=>'Manage DirectoryInformation', 'url'=>array('admin')),
);
?>

<h1>Create DirectoryInformation</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>