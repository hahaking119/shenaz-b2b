<?php
/* @var $this MembershipController */
/* @var $model Membership */

$this->breadcrumbs=array(
	'Membership Option'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Membership Options', 'url'=>array('index')),
	array('label'=>'Manage Membership Options', 'url'=>array('admin')),
);
?>

<h1>Create Membership Option</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>