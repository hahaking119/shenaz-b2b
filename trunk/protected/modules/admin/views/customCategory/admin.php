<?php
/* @var $this CustomCategoryController */
/* @var $model CustomCategory */

$this->breadcrumbs = array(
    'Custom Categories' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List CustomCategory', 'url' => array('index')),
    array('label' => 'Create CustomCategory', 'url' => Yii::app()->createAbsoluteUrl('admin/customCategory/create/id/'.$id)),
);

//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
//$('.search-form form').submit(function(){
//	$('#custom-category-grid').yiiGridView('update', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
?>

<h1>Manage Custom Categories</h1>

<?php // echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
//    $this->renderPartial('_search', array(
//        'model' => $model,
//    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'custom-category-grid',
    'dataProvider' => $model->search(array('condition' => 'company_id = ' . $id . ' and trash = 0')),
    'filter' => $model,
    'columns' => array(
        'id',
        array(
            'name' => 'company_id',
            'value' => '$data->company->company_name'
        ),
        'title',
        array(
            'name' => 'parent_id',
            'type' => 'raw',
            'header' => 'Parent Category',
            'value' => '($data->parent_id == 0)? "Parent":CustomCategory::model()->findByPk($data->parent_id)->title'
        ),
        array(
            'name' => 'status',
            'type' => 'raw',
            'header' => 'Status',
            'value' => 'CHtml::dropDownList("Category[status]", $data->status, array("Draft", "Publish"))',
            'filter' => array('' => 'All', '0' => 'Draft', '1' => 'Publish')
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 60px'),
            'template' => '{view}{update}{trash}',
            'buttons' => array(
                'trash' => array(
                    'label' => 'Trash',
                    'icon' => 'icon-trash',
                    'url' => 'Yii::app()->createAbsoluteUrl("admin/customCategory/trash", array("id"=>$data->id))',
                    'click' => 'js:function(){return confirm("Are you sure you want to trash the custom category?")}'
                ),
            )
        ),
    ),
));
?>
