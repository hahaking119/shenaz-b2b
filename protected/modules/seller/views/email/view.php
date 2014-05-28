<?php
/* @var $this EmailController */
/* @var $model Email */

$this->breadcrumbs = array(
    'Emails' => array('index'),
    $model->email_id,
);

$this->menu = array(
    array('label' => 'List Email', 'url' => array('index')),
    array('label' => 'Create Email', 'url' => array('create')),
    array('label' => 'Update Email', 'url' => array('update', 'id' => $model->email_id)),
    array('label' => 'Delete Email', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->email_id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Email', 'url' => array('admin')),
);
?>

<h1>View Email - <?php echo $model->subject; ?></h1>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'email_id',
        array(
            'name' => 'from',
            'type' => 'raw',
            'value' => ($model->from == "") ? ($model->from_email) : (Member::model()->findByPk($model->from)->email)
        ),
        'subject',
        array(
            'name' => 'message',
            'type' => 'raw',
            'value' => html_entity_decode($model->message)
        ),
        array(
            'name' => 'created_at',
            'type' => 'raw',
            'value' => CommonClass::getDateFormat($model->created_at)
        ),
    ),
));
?>
<div class="row">
    <div class="span2">
        <a href="<?php echo Yii::app()->createAbsoluteUrl('seller/email/reply/id/' . $model->email_id); ?>">Reply</a>
    </div>
</div>
