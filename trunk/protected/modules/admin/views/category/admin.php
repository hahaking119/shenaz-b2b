<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs = array(
    'Categories' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Category', 'url' => array('index')),
    array('label' => 'Create Category', 'url' => array('create')),
);
?>

<h1>Manage Categories</h1>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => 'striped bordered condensed',
    'dataProvider' => $model->search(),
    'template' => "{items}",
    'columns' => array(
        'category_id',
        'title',
        array(
            'name' => 'parent_id',
            'type' => 'raw',
            'header' => 'Parent Category',
            'value' => '($data->parent_id == 0)? "Parent":Category::model()->findByPk($data->parent_id)->title'
        ),
        array(
            'name' => 'image',
            'type' => 'raw',
            'header' => 'Image',
            'value' => '($data->image != "")?CHtml::image(Yii::app()->createAbsoluteUrl("uploads/category/image/thumbs/".$data->image), "", array("style" => "width: 20%", "class" => "thumbnail")): ""'
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
                    'url' => 'Yii::app()->createAbsoluteUrl("admin/category/trash", array("id"=>$data->category_id))',
                    'click' => 'js:function(){return confirm("Are you sure you want to trash the category?")}'
                ),
            )
        ),
    ),
));
?>
