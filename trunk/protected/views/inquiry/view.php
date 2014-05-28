<?php
/* @var $this InquiryController */
/* @var $model Email */
?>
<h1>View Email - <?php echo $model->subject; ?></h1>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
//        'email_id',
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
        <a href="<?php echo Yii::app()->createAbsoluteUrl('inquiry/reply/id/' . $model->email_id); ?>">Reply</a>
    </div>
</div>
