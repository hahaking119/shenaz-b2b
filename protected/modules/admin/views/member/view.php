<?php
/* @var $this MemberController */
/* @var $model Member */

$this->breadcrumbs = array(
    'Members' => array('index'),
    $model->member_id,
);

$this->menu = array(
    array('label' => 'List Members', 'url' => array('index')),
    array('label' => 'Add Member', 'url' => array('create')),
    array('label' => 'Update Member', 'url' => array('update', 'id' => $model->member_id)),
    array('label' => 'Trash Member', 'url' => '#', 'linkOptions' => array('submit' => array('trash', 'id' => $model->member_id), 'confirm' => 'Are you sure you want to trash this item?')),
    array('label' => 'Manage Members', 'url' => array('admin')),
);
?>

<h1>View Member - <?php echo $model->first_name; ?></h1>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'member_id',
        array(
            'name' => 'first_name',
            'value' => $model->getName($model->member_id)
        ),
        'email',
        'phone',
        array(
            'name' => 'activation_status',
            'value' => ($model->activation_status == 1) ? 'Activated' : 'Not Activated'
        ),
        array(
            'name' => 'status',
            'value' => ($model->status == 1) ? 'Active' : 'Inactive'
        )
    ),
));
?>
