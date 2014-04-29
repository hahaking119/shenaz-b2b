<?php
/* @var $this AdministratorController */
/* @var $model Administrator */

$this->breadcrumbs = array(
    'Administrators' => array('index'),
    $model->administrator_id,
);

$this->menu = array(
    array('label' => 'List Administrators', 'url' => array('index')),
    array('label' => 'Add Administrator', 'url' => array('create')),
    array('label' => 'Update Administrator', 'url' => array('update', 'id' => $model->administrator_id)),
    array('label' => 'Trash Administrator', 'url' => '#', 'linkOptions' => array('submit' => array('trash', 'id' => $model->administrator_id), 'confirm' => 'Are you sure you want to trash the administrator?')),
    array('label' => 'Manage Administrators', 'url' => array('admin')),
);
?>

<h1>View Administrator - <?php echo $model->first_name . ' ' . $model->last_name; ?></h1>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => '#',
            'value' => $model->administrator_id
        ),
        'email',
        'first_name',
        'middle_name',
        'last_name',
        array(
            'label' => 'status',
            'value' => ($model->status == 1) ? 'Active' : 'Inactive'
        )
    ),
));
?>
