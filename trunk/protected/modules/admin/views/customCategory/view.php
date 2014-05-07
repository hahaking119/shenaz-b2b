<?php
/* @var $this CustomCategoryController */
/* @var $model CustomCategory */

$this->breadcrumbs = array(
    'Custom Categories' => array('index'),
    $model->title,
);

$this->menu = array(
    array('label' => 'List CustomCategory', 'url' => array('index')),
    array('label' => 'Create CustomCategory', 'url' => array('create')),
    array('label' => 'Update CustomCategory', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete CustomCategory', 'url' => '#', 'linkOptions' => array('submit' => array('trash', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage CustomCategory', 'url' => Yii::app()->createAbsoluteUrl('admin/customCategory/admin/id/' . $model->company_id)),
);
?>

<h1>View Custom Category - <?php echo $model->title; ?></h1>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        array(
            'name' => 'company_id',
            'value' => $model->company->company_name
        ),
        'title',
        array(
            'name' => 'parent_id',
            'value' => ($model->parent_id == 0) ? 'Parent' : CustomCategory::model()->findByPk($model->parent_id)->title
        ),
        array(
            'name' => 'status',
            'value' => ($model->status == 1) ? 'Publish' : 'Draft'
        )
    ),
));
?>
