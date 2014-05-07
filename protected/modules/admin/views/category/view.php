<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs = array(
    'Categories' => array('index'),
    $model->title,
);

$this->menu = array(
    array('label' => 'List Categories', 'url' => array('index')),
    array('label' => 'Create Category', 'url' => array('create')),
    array('label' => 'Update Category', 'url' => array('update', 'id' => $model->category_id)),
    array('label' => 'Trash Category', 'url' => '#', 'linkOptions' => array('submit' => array('trash', 'id' => $model->category_id), 'confirm' => 'Are you sure you want to trash this item?')),
    array('label' => 'Manage Categories', 'url' => array('admin')),
);
?>

<h1>View Category - <?php echo $model->title; ?></h1>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'category_id',
        'title',
        array(
            'name' => 'parent_id',
            'value' => ($model->parent_id == 0) ? 'Parent Category' : Category::model()->findByPk($model->parent_id)->title
        ),
        array(
            'name' => 'image',
            'type' => 'raw',
            'value' => ($model->image != '') ? CHtml::image(Yii::app()->createAbsoluteUrl('uploads/category/image/thumbs/' . $model->image), '', array('style' => 'width:20%', 'class' => 'thumbnail')) : ''
        ),
        array(
            'name' => 'status',
            'value' => ($model->status == 1) ? 'Publish' : 'Draft'
        )
    ),
));
?>
