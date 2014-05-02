<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Category', 'url'=>array('index')),
	array('label'=>'Create Category', 'url'=>array('create')),
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
        'slug',
        'parent_id',
        'image',
        'status',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 60px'),
            'template' => '{view}{update}{delete}',
        ),
    ),
));
?>
