<?php
/* @var $this MemberController */
/* @var $model Member */

$this->breadcrumbs=array(
	'Members'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Members', 'url'=>array('index')),
	array('label'=>'Manage Members', 'url'=>array('admin')),
);
?>

<h1>Add Member</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>