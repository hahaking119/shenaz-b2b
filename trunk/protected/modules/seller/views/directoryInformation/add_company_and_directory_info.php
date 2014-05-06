<?php
/* @var $this MemberController */
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

<h1><?php if($model->isNewRecord) echo 'Create '; else echo "Edit "; ?>Directory Information</h1>

<?php echo $this->renderPartial('_directory_&_company_info_form', array('model'=>$model, 'companyInformation' => $companyInformation)); ?>