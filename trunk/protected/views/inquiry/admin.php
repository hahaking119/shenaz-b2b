<?php
/* @var $this InquiryController */
/* @var $model Email */

//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
//$('.search-form form').submit(function(){
//	$('#email-grid').yiiGridView('update', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
?>

<h1>Manage</h1>


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
    'id' => 'email-grid',
    'dataProvider' => $model->search(array('condition' => '`to`=' . Yii::app()->user->getId().' OR `from`='.Yii::app()->user->getId())),
    'filter' => $model,
    'rowCssClassExpression' => '($data->read == 0)? ("unread"):("")',
    'columns' => array(
        array(
            'name' => 'from',
            'type' => 'raw',
            'value' => '($data->from == "")? ($data->from_email) : (Member::model()->findByPk($data->from)->email)'
        ),
        'subject',
        array(
            'name' => 'message',
            'type' => 'raw',
            'value' => 'CommonClass::getShortDescription($data->message, 100)'
        ),
        array(
            'name' => 'created_at',
            'type' => 'raw',
            'value' => 'CommonClass::getDateFormat($data->created_at)'
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 50px', 'padding-top' => '0'),
            'template' => '{view}',
        ),
    ),
));
?>
