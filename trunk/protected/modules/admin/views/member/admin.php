<?php
/* @var $this MemberController */
/* @var $model Member */

$this->breadcrumbs=array(
	'Members'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Member', 'url'=>array('index')),
	array('label'=>'Create Member', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#member-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Members</h1>

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

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => 'striped bordered condensed',
    'dataProvider' => $model->search(),
    'template' => "{items}",
    'columns' => array(
        'member_id',
        'email',
        'password',
        'password_text',
        'first_name',
        'middle_name',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 60px'),
            'template' => '{view}{update}{add}{delete}',
            'buttons' => array(
                'add' => array(
                    'label' => 'Add Company/Directory Information',
                    'icon' => 'icon-plus',
                    'url' => 'Yii::app()->createAbsoluteUrl("admin/member/add_directory_company_info", array("id"=>$data->member_id))',
                ),
//                'trash' => array(
//                    'label' => 'Trash',
//                    'icon' => 'icon-trash',
//                    'url' => 'Yii::app()->createAbsoluteUrl("admin/registrant/trash", array("id"=>$data->id))',
//                    'click' => 'js:function(){return confirm("Are you sure you want to trash the retailer information?")}'
//                ),
            ),
        ),
    ),
));
?>
