<?php
/* @var $this MembershipController */
/* @var $model Membership */

$this->breadcrumbs=array(
	'Memberships'=>array('index'),
	$model->title=>array('view','id'=>$model->membership_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Membership', 'url'=>array('index')),
	array('label'=>'Create Membership', 'url'=>array('create')),
	array('label'=>'View Membership', 'url'=>array('view', 'id'=>$model->membership_id)),
	array('label'=>'Manage Membership', 'url'=>array('admin')),
);
?>

<h1>Update Membership <?php echo $model->membership_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>