<?php
/* @var $this DirectoryInformationController */
/* @var $model DirectoryInformation */

$this->breadcrumbs=array(
	'Directory Informations'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List DirectoryInformation', 'url'=>array('index')),
	array('label'=>'Create DirectoryInformation', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#directory-information-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Directory Informations</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'directory-information-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'directory_id',
		'company_id',
		'first_name',
		'middle_name',
		'last_name',
		'job_title',
		/*
		'image',
		'email',
		'phone',
		'fax',
		'zip_code',
		'address',
		'area',
		'province',
		'country',
		'status',
		'trash',
		'created_at',
		'modified_at',
		'trashed_at',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
