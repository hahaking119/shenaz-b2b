<?php
/* @var $this MemberSettingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Member Settings',
);

$this->menu=array(
	array('label'=>'Create MemberSetting', 'url'=>array('create')),
	array('label'=>'Manage MemberSetting', 'url'=>array('admin')),
);
?>

<h1>Member Settings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
