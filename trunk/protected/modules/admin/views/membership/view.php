<?php
/* @var $this MembershipController */
/* @var $model Membership */

$this->breadcrumbs = array(
    'Memberships' => array('index'),
    $model->title,
);

$this->menu = array(
    array('label' => 'List Membership Options', 'url' => array('index')),
    array('label' => 'Create Membership Option', 'url' => array('create')),
    array('label' => 'Update Membership Option', 'url' => array('update', 'id' => $model->membership_id)),
    array('label' => 'Trash Membership Option', 'url' => '#', 'linkOptions' => array('submit' => array('trash', 'id' => $model->membership_id), 'confirm' => 'Are you sure you want to trash this item?')),
    array('label' => 'Manage Membership Options', 'url' => array('admin')),
);
?>

<h1>View Membership Option - <?php echo $model->title; ?></h1>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'membership_id',
        'title',
        'description',
        'shopfront_limit',
        'product_limit',
        array(
            'name' => 'status',
            'value' => ($model->status == 1)? 'Active' : 'Inactive'
        )
    ),
));
?>
