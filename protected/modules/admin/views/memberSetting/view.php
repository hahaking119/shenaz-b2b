<?php
/* @var $this MemberSettingController */
/* @var $model MemberSetting */

$this->breadcrumbs=array(
	'Member Settings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MemberSetting', 'url'=>array('index')),
	array('label'=>'Create MemberSetting', 'url'=>array('create')),
	array('label'=>'Update MemberSetting', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MemberSetting', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MemberSetting', 'url'=>array('admin')),
);
?>

<h1>View MemberSetting #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'member_id',
		'theme',
		'currency',
		'created_at',
		'modified_at',
	),
)); ?>
