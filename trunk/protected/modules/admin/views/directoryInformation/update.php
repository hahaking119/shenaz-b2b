<?php
/* @var $this DirectoryInformationController */
/* @var $model DirectoryInformation */

$this->breadcrumbs=array(
	'Directory Informations'=>array('index'),
	$model->directory_id=>array('view','id'=>$model->directory_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DirectoryInformation', 'url'=>array('index')),
	array('label'=>'Create DirectoryInformation', 'url'=>array('create')),
	array('label'=>'View DirectoryInformation', 'url'=>array('view', 'id'=>$model->directory_id)),
	array('label'=>'Manage DirectoryInformation', 'url'=>array('admin')),
);
?>

<h1>Update DirectoryInformation <?php echo $model->directory_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>