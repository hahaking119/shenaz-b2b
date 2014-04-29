<?php
/* @var $this MemberSettingController */
/* @var $model MemberSetting */

$this->breadcrumbs=array(
	'Member Settings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MemberSetting', 'url'=>array('index')),
	array('label'=>'Create MemberSetting', 'url'=>array('create')),
	array('label'=>'View MemberSetting', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MemberSetting', 'url'=>array('admin')),
);
?>

<h1>Update MemberSetting <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>