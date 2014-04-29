<?php
/* @var $this MemberSettingController */
/* @var $model MemberSetting */

$this->breadcrumbs=array(
	'Member Settings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MemberSetting', 'url'=>array('index')),
	array('label'=>'Manage MemberSetting', 'url'=>array('admin')),
);
?>

<h1>Create MemberSetting</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>